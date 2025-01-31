<?php

namespace App\Modules\Cart\Tests\Integration;

use App\Modules\Cart\Model\Cart;
use App\Modules\Cart\Model\CartItem;
use App\Modules\Cart\Tests\PaymentService;
use App\Modules\Product\Model\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Mockery\MockInterface;
use Tests\TestCase;

class WhenAddingProductToCartTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function cart_contains_a_product(): void
    {
        //arrange
        $product = Product::factory()->create();
        $guestId = 10;

        //act
        $response = $this->post(sprintf('/cart/add/%d',$product->getKey()),[],[
            'token' => $guestId
        ]);

        //assert
        $response->assertSuccessful();
        $this->assertDatabaseCount('carts',1);
        $this->assertDatabaseHas('cart_items',[
            'product_id' => $product->getKey()
        ]);
    }

    /** @test */
    public function adding_duplicate_cart_item_increases_the_cart_item_quantity():void
    {
        //Arrange
        $guestId = 10;
        $product = Product::factory()->create();
        $cart = Cart::factory()
            ->whichBelongsTo($guestId)
            ->create();
        CartItem::factory()
            ->forProduct($product)
            ->create(['cart_id' => $cart->getKey()]);


        //Act
        $response = $this->post(sprintf('/cart/add/%d',$product->getKey()),[],[
            'token' => $guestId
        ]);

        //Assert
        $this->assertDatabaseHas('cart_items',[
            'product_id' => $product->getKey(),
            'cart_id'  => $cart->getKey(),
            'quantity' => 2
        ]);

    }

    /** @test */
    public function user_can_pay_invoice_successfully():void
    {
        //Arrange
        Mail::fake();

        $stub = $this->mock(\UserVerifier::class,function(MockInterface $mock){
            $mock->shouldReceive('verify')
                ->andReturn(true);
        });
        $sut = new PaymentService($stub);

        //Act
        $sut->pay();

        //Assert
        Mail::assertQueued();

    }
}
