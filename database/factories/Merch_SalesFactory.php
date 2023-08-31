<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\followers;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class Merch_SalesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $follower = followers::inRandomOrder()->first();
        return [
            'user_id' => rand(1, 12),
            'follower_name' => $follower->name,
            'item_name' => $this->faker->word,
            'quantity' => $this->faker->numberBetween(1, 20),
            'price' => $this->faker->randomFloat(2, 5, 200),
            'is_read' => false,
            'created_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
