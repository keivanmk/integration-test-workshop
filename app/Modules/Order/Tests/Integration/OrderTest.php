<?php

namespace App\Modules\Order\Tests\Integration;

use App\Models\User;
use App\Modules\Cart\Model\Cart;
use App\Modules\Cart\Model\CartItem;
use App\Modules\Order\Mails\OrderPlacedMail;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
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
}
