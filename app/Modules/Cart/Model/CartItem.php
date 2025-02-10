<?php

namespace App\Modules\Cart\Model;

use App\Modules\Product\Model\Product;
use Database\Factories\CartFactory;
use Database\Factories\CartItemFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 *@property int $cart_id
 *@property int $product_id
 *@property Product $product
 *@property int $price
 *@property int $quantity
 *@property string $title
 */
class CartItem extends Model
{
    use HasFactory;

    public static function newFactory():Factory
    {
        return CartItemFactory::new();
    }

    public static function add(Product $product):CartItem
    {
        $cartItem = new CartItem;
        $cartItem->product_id = $product->getKey();
        $cartItem->price = $product->price;
        $cartItem->title = $product->title;
        $cartItem->quantity = 1;
        return $cartItem;
    }

    public function cart():BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function product():HasOne
    {
        return $this->hasOne(Product::class);
    }

    public function increaseQuantity(int $amount = 1):void
    {
        $this->increment('quantity',$amount);
    }

    public function subTotal():int
    {
        return  $this->price * $this->quantity;
    }
}
