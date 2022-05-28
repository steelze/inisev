<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Website;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            WebsiteSeeder::class,
            UserSeeder::class,
            PostSeeder::class,
        ]);

        $websites = Website::select('id')->get();

        User::all()->each(function ($user) use ($websites) { 
            $websiteIds = $websites->random(rand(1, $websites->count()))->pluck('id')->toArray();
            $user->websites()->attach($websiteIds); 
        });
    }
}
