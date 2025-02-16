<?php

namespace Database\Factories;

use App\Models\User;
use App\Modules\Order\Model\Order;
use App\Modules\Order\Model\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'owner_id' => User::factory(),
            'total' => $this->faker->numberBetween(1_000_000,2_000_000),
            'status' => OrderStatus::PENDING
        ];
    }

    public function confirmed():Factory
    {
        return  $this->state(fn(array $attributes) => ['status' => OrderStatus::CONFIRMED]);
    }
}
