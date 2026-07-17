<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'first_name' => 'admin',
                'last_name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ],
            [
                'first_name' => 'Vukasin',
                'last_name' => 'Antic',
                'email' => 'vukasin@gmail.com',
                'password' => Hash::make('vukasin123'),
                'role' => 'user',
            ],
            [
                'first_name' => 'Milica',
                'last_name' => 'Jovanovic',
                'email' => 'milica.jovanovic@gmail.com',
                'password' => Hash::make('milica123'),
                'role' => 'user',
            ],
            [
                'first_name' => 'Nikola',
                'last_name' => 'Petrovic',
                'email' => 'nikola.petrovic@gmail.com',
                'password' => Hash::make('nikola123'),
                'role' => 'user',
            ],
            [
                'first_name' => 'Jelena',
                'last_name' => 'Stojanovic',
                'email' => 'jelena.stojanovic@gmail.com',
                'password' => Hash::make('jelena123'),
                'role' => 'user',
            ],
            [
                'first_name' => 'Marko',
                'last_name' => 'Ilic',
                'email' => 'marko.ilic@gmail.com',
                'password' => Hash::make('marko123'),
                'role' => 'user',
            ],
        ];

        foreach ($users as $user) {
            // Seeded accounts are pre-verified so they can log in right away
            $user['email_verified_at'] = now();
            User::create($user);
        }
    }
}
