<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Profile;
use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $darbs = Category::create(['name' => 'Darbs']);
        $pakalpojumi = Category::create(['name' => 'Pakalpojumi']);
        $remonts = Category::create(['name' => 'Remonts']);
        $dizains = Category::create(['name' => 'Dizains']);
        $programmesana = Category::create(['name' => 'Programmēšana']);

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('adminpassword'),
        ]);

        $user = User::create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => bcrypt('userpassword'),
        ]);

        Profile::create([
            'user_id' => $admin->id,
            'bio' => 'Administratora profils',
            'city' => 'Riga',
        ]);

        Profile::create([
            'user_id' => $user->id,
            'bio' => 'Parasts lietotājs',
            'city' => 'Riga',
        ]);

        Post::create([
            'user_id' => $user->id,
            'category_id' => $darbs->id,
            'title' => 'Meklēju santehniķi',
            'description' => 'Nepieciešams salabot virtuves izlietni.',
            'type' => 'service',
            'is_active' => true,
        ]);
    }
}