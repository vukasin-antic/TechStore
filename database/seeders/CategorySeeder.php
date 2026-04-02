<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $laptops = Category::create(['name' => 'Laptops']);
        $desktops = Category::create(['name' => 'Desktops']);
        $monitors = Category::create(['name' => 'Monitors']);
        $phones = Category::create(['name' => 'Phones']);
        $peripherals = Category::create(['name' => 'Peripherals']);
        $components = Category::create(['name' => 'Components']);

        Category::create(['name' => 'Android', 'parent_id' => $phones->id]);
        Category::create(['name' => 'iOS', 'parent_id' => $phones->id]);
        Category::create(['name' => 'Mice', 'parent_id' => $peripherals->id]);
        Category::create(['name' => 'Keyboards', 'parent_id' => $peripherals->id]);
        Category::create(['name' => 'RAM', 'parent_id' => $components->id]);
        Category::create(['name' => 'SSD', 'parent_id' => $components->id]);
    }
}
