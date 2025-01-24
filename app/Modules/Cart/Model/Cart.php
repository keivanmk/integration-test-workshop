<?php

namespace App\Modules\Cart\Model;

use App\Modules\Product\Model\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $user_id
 * @property string $guest_id
 */
class Cart extends Model
{

    private Collection $items;

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

    public function addProduct(Product $product)
    {
//        $this->items()->save($product);
        $this->items->add($product);
    }
}
