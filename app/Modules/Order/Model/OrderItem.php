<?php

namespace App\Modules\Order\Model;

use App\Modules\Cart\Model\CartItem;
use Database\Factories\OrderItemFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *@property int $order_id
 *@property int $product_id
 *@property string $title
 *@property int $price
 *@property int $quantity
 */
class OrderItem extends Model
{

    use HasFactory;

    protected $table = 'order_item';

    public static function newFactory():Factory
    {
        return OrderItemFactory::new();
    }

    public static function createFromCartItem(CartItem $cartItem):OrderItem
    {
        $orderItem = new OrderItem;
        $orderItem->product_id = $cartItem->product_id;
        $orderItem->title = $cartItem->title;
        $orderItem->price = $cartItem->price;
        $orderItem->quantity = $cartItem->quantity;
        return $orderItem;

    }

    public function subTotal():int
    {
        return $this->price * $this->quantity;
    }
}
