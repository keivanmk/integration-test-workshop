<?php

namespace App\Modules\Product\Model;

use Carbon\Carbon;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *@property string $title
 *@property string $category
 *@property int $price
 *@property int $quantity
 *@property Carbon $created_at
 *@property Carbon $updated_at

 */
class Product extends Model
{
    use HasFactory;

    const string INVALID_QUANTITY_ERROR_MESSAGE = "موجودی محصول نمی تواند منفی باشد.";
    const string INVALID_PRICE_ERROR_MESSAGE = "قیمت محصول نمی تواند منفی باشد.";

    public static function newFactory(): Factory
    {
        return  ProductFactory::new();
    }

    public static function add(string $title, int $price, string $category, int $quantity):Product
    {
        $product = new Product();
        $product->title = $title;
        throw_if($price < 0,new \InvalidArgumentException(self::INVALID_PRICE_ERROR_MESSAGE));
        $product->price = $price;
        $product->category = $category;
        self::validateQuantity($quantity);
        $product->quantity = $quantity;

        return $product;
    }


    private static function validateQuantity(int $quantity): void
    {
        throw_if($quantity < 0, new \InvalidArgumentException(self::INVALID_QUANTITY_ERROR_MESSAGE));
    }

    public function changeQuantityTo(int $newQuantity):void
    {
        self::validateQuantity($newQuantity);
        $this->quantity = $newQuantity;
    }

    public function changeDetails(string $newTitle, int $newPrice, string $newCategory):void
    {
        $this->title = $newTitle;
        throw_if($newPrice < 0,new \InvalidArgumentException(self::INVALID_PRICE_ERROR_MESSAGE));
        $this->price = $newPrice;
        $this->category = $newCategory;
    }

    public function toReadModel():ProductReadModel
    {
        return  new ProductReadModel(
            $this->title,
            $this->price,
            $this->category,
            $this->quantity
        );
    }
}
