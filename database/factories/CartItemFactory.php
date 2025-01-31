<?php

namespace Database\Factories;

use App\Modules\Cart\Model\CartItem;
use App\Modules\Product\Model\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CartItemFactory extends Factory
{
    protected $model= CartItem::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => 0,
            'cart_id' => 0,
            'title' => $this->faker->word(),
            'price' => 100,
            'quantity' => 1
        ];
    }

    public function forProduct(Product $product):Factory
    {
        return $this->state(function(array $attributes)use($product){
            return [
                'product_id' => $product->getKey(),
                'title' => $product->title,
                'price' => $product->price,
                'quantity'  => 1
            ];
        });
    }
}
