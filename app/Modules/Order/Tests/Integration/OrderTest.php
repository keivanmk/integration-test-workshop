<?php

namespace App\Modules\Order\Tests\Integration;

use App\Models\User;
use App\Modules\Cart\Model\Cart;
use App\Modules\Cart\Model\CartItem;
use App\Modules\Order\Contracts\TaxProviderInterface;
use App\Modules\Order\Mails\OrderPlacedMail;
use App\Modules\Order\Model\Events\OrderCanceled;
use App\Modules\Order\Model\Order;
use App\Modules\Order\Model\OrderStatus;
use App\Modules\Order\UseCases\CancelOrderUseCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Mockery\MockInterface;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function placing_order():void
    {
        //Arrange
        Mail::fake();
        $customer = User::factory()->create();
        /** @var Cart $cart */
        $cart = Cart::factory()
            ->whichBelongsTo($customer->getKey())
            ->has(CartItem::factory()->count(3),'items')
            ->create();
        $this->mock(TaxProviderInterface::class,function (MockInterface $mock){
            $mock->shouldReceive('rate')
                ->andReturn(0);
        });

        //Act
        $response = $this->post('/order/place',[],[
            'token' => $customer->getKey()
        ]);

        //Assert
        $response->assertSuccessful();
        $this->assertDatabaseHas('orders',[
            'owner_id' => $customer->getKey(),
            'total' => $cart->total()
        ]);
        Mail::assertSent(OrderPlacedMail::class,$customer->email);

    }

    /** @test */
    public function canceling_order():void
    {
        //Arrange
        Event::fake();
        $order = Order::factory()->confirmed()->create();
        $sut = app(CancelOrderUseCase::class);

        //Act
        $sut->execute($order);

        //Assert
        $this->assertDatabaseHas('orders',[
            'id' => $order->getKey(),
            'status'  => OrderStatus::CANCELED
        ]);
        Event::assertDispatched(OrderCanceled::class);

    }

    /** @test */
    public function apply_value_added_tax_on_placing_order():void
    {
        //Arrange
        $customer = User::factory()->create();
        /** @var Cart $cart */
        $cart = Cart::factory()
            ->whichBelongsTo($customer->getKey())
            ->has(CartItem::factory()->count(3),'items')
            ->create();
        $expectedTotal = $cart->total() * 1.1;
        $this->mock(TaxProviderInterface::class,function (MockInterface $mock){
            $mock->shouldReceive('rate')
                ->andReturn(10);
        });

        //Act
        $response = $this->post('/order/place',[],[
            'token' => $customer->getKey()
        ]);

        //Assert
        $this->assertDatabaseHas('orders',[
            'owner_id' => $customer->getKey(),
            'total' => $expectedTotal
        ]);

    }
}
