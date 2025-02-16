<?php

namespace App\Modules\Order\UseCases;

use App\Modules\Order\Model\Events\OrderCanceled;
use App\Modules\Order\Model\Order;
use Illuminate\Contracts\Events\Dispatcher;

class CancelOrderUseCase
{

    public function __construct(private Dispatcher $dispatcher)
    {
    }

    public function execute(Order $order):void
    {
        $order->cancel();
        $order->save();

        $this->dispatcher->dispatch(new OrderCanceled($order));
    }
}
