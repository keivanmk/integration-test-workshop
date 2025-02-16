<?php

namespace App\Modules\Payment\Listeners;

use App\Modules\Order\Model\Events\OrderCanceled;
use App\Modules\Payment\Contracts\PaymentGateway;
use App\Modules\Payment\Model\Transaction;
use App\Modules\Payment\Services\PaymentService;

class RefundOrderPayment
{


    public function __construct(
        private PaymentService $paymentService
    )
    {
    }

    public function handle(OrderCanceled $orderCanceled):void
    {
        $order  = $orderCanceled->order;
        $this->paymentService->refund($order);

    }
}
