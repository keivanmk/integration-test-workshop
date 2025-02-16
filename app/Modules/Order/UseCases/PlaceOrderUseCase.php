<?php

namespace App\Modules\Order\UseCases;

use App\Modules\Cart\Model\Cart;
use App\Modules\Cart\Model\CartItem;
use App\Modules\Order\Contracts\TaxProviderInterface;
use App\Modules\Order\Events\OrderPlaced;
use App\Modules\Order\Mails\OrderPlacedMail;
use App\Modules\Order\Model\Order;
use App\Modules\Order\Model\OrderItem;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Mail;

readonly class PlaceOrderUseCase
{


    public function __construct(
        private Dispatcher $eventDispatcher,
        private TaxProviderInterface $taxProvider
    )
    {
    }

    public function execute(Cart $cart):void
    {
        $orderItems = $cart->items->map(fn(CartItem $cartItem) => OrderItem::createFromCartItem($cartItem));
        $order = Order::place($cart->guest_id);
        $order->save();
        $order->addItems($orderItems);
        $order->applyTax($this->taxProvider->rate());
        $order->save();

        $this->eventDispatcher->dispatch(new OrderPlaced($order));

    }
}
