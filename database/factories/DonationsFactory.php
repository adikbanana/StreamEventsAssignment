<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\followers;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donations>
 */
class DonationsFactory extends Factory
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
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'currency' => $this->faker->currencyCode,
            'donation_message' => $this->faker->sentence,
            'is_read' => false,
            'created_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
