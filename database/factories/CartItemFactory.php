<?php

namespace Database\Factories;

use App\Modules\Cart\Model\Cart;
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
            'product_id' => Product::factory(),
            'cart_id' => Cart::factory(),
            'title' => $this->faker->word(),
            'price' => $this->faker->randomElement([100_000,200_000,300_000,400_000,500_000]),
            'quantity' => $this->faker->randomDigitNotZero()
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
