<?php

namespace App\Modules\Payment\Providers;

use App\Modules\Order\Model\Events\OrderCanceled;
use App\Modules\Payment\Listeners\RefundOrderPayment;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function boot():void
    {
        Event::listen(OrderCanceled::class,RefundOrderPayment::class);
    }
}
