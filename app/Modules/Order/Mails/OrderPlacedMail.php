<?php

namespace App\Modules\Order\Mails;

use App\Modules\Order\Model\Order;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class OrderPlacedMail extends Mailable
{

    public function __construct(public Order $order)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('support@ecommerce.com', 'Ecommerce Website'),
            subject: sprintf('سفارش شما ثبت شد #%d',$this->order->getKey()),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.order.placed',
        );
    }
}
