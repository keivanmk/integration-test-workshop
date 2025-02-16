<?php

namespace App\Modules\Order\Tests\Unit;

use App\Modules\Order\Model\Exceptions\CouldNotCancelOrderException;
use App\Modules\Order\Model\Order;
use App\Modules\Order\Model\OrderItem;
use App\Modules\Order\Model\OrderStatus;
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

    /** @test */
    public function canceling_order():void
    {
        //Arrange
        /** @var Order $sut */
        $sut = Order::factory()->confirmed()->make();

        //Act
        $sut->cancel();

        //Assert
//        $this->assertTrue($sut->isCanceled());
        $this->assertEquals(OrderStatus::CANCELED,$sut->status);

    }

    /** @test */
    public function not_possible_to_cancel_a_pending_order():void
    {
        //Arrange
        $sut = Order::factory()->make();

        //Assert
        $this->expectException(CouldNotCancelOrderException::class);
        $this->expectExceptionMessage(CouldNotCancelOrderException::CAUSE_ITS_ALREADY_ON_PENDING_MSG);

        //Act
        $sut->cancel();


    }
}
