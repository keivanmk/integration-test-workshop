<?php

namespace App\Modules\Order\Model\Events;

use App\Modules\Order\Model\Order;

readonly class OrderCanceled
{

    public function __construct(public Order $order)
    {

    }
}
