<?php

namespace App\Modules\Order\Tests\Unit;

use App\Modules\Order\Model\Order;
use App\Modules\Order\Model\OrderItem;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /** @test */
    public function placing_order():void
    {

        //Arrange
        $owner = 10;
        $orderItems = OrderItem::factory()
            ->count(2)
            ->make();

        //Act
//        $order = Order::place($owner,$orderItems);

        //Assert

//        $this->assertInstanceOf(Order::class);

    }
}
