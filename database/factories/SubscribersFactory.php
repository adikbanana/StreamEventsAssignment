<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\followers;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscribers>
 */
class SubscribersFactory extends Factory
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
            'subscription_tier' => $this->faker->numberBetween(1, 3),
            'is_read' => false,
            'created_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
