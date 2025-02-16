<?php

namespace App\Modules\Payment\Services;

use App\Modules\Order\Model\Order;
use App\Modules\Payment\Contracts\PaymentGateway;
use App\Modules\Payment\Model\Transaction;

readonly class PaymentService
{


    public function __construct(
        private PaymentGateway $paymentGateway
    )
    {
    }

    public function pay(Order $order):void
    {

        $transaction = Transaction::create($order);
        $transaction->save();

        $this->paymentGateway->pay($order->total);

    }

    public function refund(Order $order):void
    {
        $transaction = Transaction::refund($order);
        $isRefundDone = $this->paymentGateway->refund($order->owner,$order->total);
        if($isRefundDone)
        {
            $transaction->successful();
            $transaction->save();
            return;
        }
        $transaction->fail();
        $transaction->save();
    }
}
