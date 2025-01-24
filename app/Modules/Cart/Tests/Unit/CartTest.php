<?php

namespace App\Modules\Cart\Tests\Unit;

use App\Modules\Cart\Model\Cart;
use App\Modules\Product\Model\Product;
use Tests\TestCase;

class CartTest extends TestCase
{
    /** @test */
    public function creating_new_cart_for_user(): void
    {
        //arrange
        $userId = 1;

        //act
        $cart = Cart::forUser($userId);

        //assert
        $this->assertInstanceOf(Cart::class,$cart);
        $this->assertEquals($userId,$cart->user_id);
    }

    /** @test */
    public function adding_item_to_cart(): void
    {
        //arrange
        $product = Product::factory()->make();
        $user_id = 1;
        $sut = Cart::forUser($user_id);

        //act
        $sut->addProduct($product);

        //assert
        $this->assertCount(1,$sut->getItemsCount());

    }

}
