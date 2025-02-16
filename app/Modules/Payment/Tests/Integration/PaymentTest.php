<?php

namespace App\Modules\Payment\Tests\Integration;

use App\Modules\Order\Model\Order;
use App\Modules\Payment\Contracts\PaymentGateway;
use App\Modules\Payment\Model\TransactionStatus;
use App\Modules\Payment\Services\PaymentService;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    /** @test */
    public function paying_an_order():void
    {

        //Arrange
        /** @var Order $order */
        $order = Order::factory()->create();

        $paymentGatewayMock = $this->mock(PaymentGateway::class,function(MockInterface $mock)use($order){
            $mock->shouldReceive('pay')
                ->once()
                ->with($order->total);
        });

        $sut = new PaymentService($paymentGatewayMock);

        //Act
        $sut->pay($order);


        //Assert
        $this->assertDatabaseHas('transactions',[
            'order_id' => $order->getKey(),
            'amount'   => $order->total,
            'status'   => 1
        ]);


    }

    /** @test */
    public function refund_an_order():void
    {
        //Arrange
        /** @var Order $order */
        $order = Order::factory()->confirmed()->create();
        $paymentGatewayMock = $this->mock(PaymentGateway::class,function(MockInterface $mock)use($order){
            $mock->shouldReceive('refund')
                ->once()
                ->with($order->owner,$order->total)
                ->andReturn(true);
        });
        $sut = new PaymentService($paymentGatewayMock);

        //Act
        $sut->refund($order);

        //Assert
        $this->assertDatabaseHas('transactions',[
            'order_id' => $order->getKey(),
            'status'  => TransactionStatus::SUCCEED,
            'amount'  => ($order->total) * -1
        ]);

    }
}
