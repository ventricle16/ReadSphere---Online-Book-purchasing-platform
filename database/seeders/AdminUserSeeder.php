<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@readsphere.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'profile_picture' => null, // Optional
                'bio' => 'Admin user for Readsphere', // Optional

            ]
        );
        User::create([
            'name' => 'Normal User',
            'email' => 'user123@example.com',
            'password' => Hash::make('password'),
            'role' => 'user'
        ]);
    }
}
