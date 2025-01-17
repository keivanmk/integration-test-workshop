<?php

namespace Database\Factories;

use App\Modules\Product\Model\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'price' => $this->faker->numberBetween(100000,10000000),
            'category' => $this->faker->word(),
            'quantity' => $this->faker->numberBetween(1,100)
        ];
    }

    public function withQuantity(int $quantity): Factory
    {
        return $this->state(function (array $attributes) use($quantity){
            return [
                'quantity' => $quantity,
            ];
        });
    }
}
