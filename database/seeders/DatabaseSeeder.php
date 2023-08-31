<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Factories\UserFactory;
use Database\Factories\FollowersFactory;
use Database\Factories\SubscribersFactory;
use Database\Factories\DonationsFactory;
use Database\Factories\Merch_SalesFactory;
use App\Models\User;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $userIds = User::inRandomOrder()->pluck('id')->toArray();
        UserFactory::new()->count(12)->create();
        FollowersFactory::new()->count(200)->create();
        SubscribersFactory::new()->count(200)->create();
        DonationsFactory::new()->count(200)->create();
        Merch_SalesFactory::new()->count(200)->create();
    }
}
