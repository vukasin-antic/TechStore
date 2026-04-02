<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Nav;

class NavSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private array $nav = [
        [
            'name' => 'Home',
            'route' => 'home',
        ],
        [
            'name' => 'Shop',
            'route' => 'shop',
        ],
        [
            'name' => 'Contact',
            'route' => 'contact',
        ],
        [
            'name' => 'Author',
            'route' => 'author',
        ],

    ];

    public function run(): void
    {
        foreach ($this->nav as $n) {
            Nav::create($n);
        }
    }
}
