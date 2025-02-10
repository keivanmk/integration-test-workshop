<?php

namespace App\Modules\Order\Tests\Unit;

use App\Modules\Cart\Model\CartItem;
use App\Modules\Order\Model\OrderItem;
use Tests\TestCase;

class OrderItemTest extends TestCase
{
    /** @test */
    public function creating_order_item():void
    {
        //Arrange
        $cartItem = CartItem::factory()->create();

        //Act
        $orderItem = OrderItem::createFromCartItem($cartItem);

        //Assert
        $this->assertInstanceOf(OrderItem::class,$orderItem);
        $this->assertEquals($cartItem->price,$orderItem->price);


    }
}
