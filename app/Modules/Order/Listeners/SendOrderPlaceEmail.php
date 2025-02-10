<?php

namespace App\Modules\Order\Listeners;

use App\Modules\Order\Events\OrderPlaced;
use App\Modules\Order\Mails\OrderPlacedMail;
use Illuminate\Support\Facades\Mail;

class SendOrderPlaceEmail
{
    public function handle(OrderPlaced $orderPlaced):void
    {
        Mail::to($orderPlaced->order->owner)->send(new OrderPlacedMail($orderPlaced->order));
    }
}
