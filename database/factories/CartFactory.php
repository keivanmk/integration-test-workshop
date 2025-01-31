<?php

namespace Database\Factories;

use App\Modules\Cart\Model\Cart;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CartFactory extends Factory
{
    protected $model = Cart::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 0,
            'guest_id' => 0
        ];
    }

    public function whichBelongsTo(string $guestId):Factory
    {
        return $this->state(function(array $attributes)use($guestId){
            return ['guest_id' => $guestId];
        });
    }
}
