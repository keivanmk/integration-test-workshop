<?php

namespace App\Modules\Cart\Model;

use App\Modules\Product\Model\Product;
use Database\Factories\CartFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $user_id
 * @property string $guest_id
 */
class Cart extends Model
{
    use HasFactory;

    public static function newFactory():Factory
    {
        return CartFactory::new();
    }

    public function items():HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public static function forUser(int $userId):Cart
    {
        $cart = new Cart();
        $cart->user_id = $userId;
        return $cart;
    }

    public static function forGuest(string $guestId):Cart
    {
        $cart = new Cart();
        $cart->guest_id = $guestId;
        return $cart;
    }


    public function addProduct(Product $product):void
    {
        /** @var CartItem $existingItem */
         $existingItem= $this->items()->where('product_id',$product->getKey())->first();
        if($existingItem)
        {
            $existingItem->increaseQuantity();
            $existingItem->save();
            return;
        }

        $this->items()->save(CartItem::add($product));
    }
}
