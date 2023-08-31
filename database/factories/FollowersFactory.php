<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Followers>
 */
class FollowersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => rand(1, 12),
            'name' => fake()->name(),
            'is_read' => false,
            'created_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
