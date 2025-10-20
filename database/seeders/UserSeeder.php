<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah@articlehub.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'michael@articlehub.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Emily Rodriguez',
                'email' => 'emily@articlehub.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'David Kim',
                'email' => 'david@articlehub.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Lisa Wang',
                'email' => 'lisa@articlehub.com',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}