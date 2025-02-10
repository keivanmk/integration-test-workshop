<?php

namespace Database\Factories;

use App\Modules\Order\Model\OrderItem;
use App\Modules\Product\Model\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<OrderItem>
 */
class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => 0,
            'product_id' => Product::factory(),
            'title' => $this->faker->word(),
            'price' => $this->faker->randomElement([100_000,200_000,300_000,400_000,500_000]),
            'quantity' => $this->faker->randomDigitNotZero()
        ];
    }
}
