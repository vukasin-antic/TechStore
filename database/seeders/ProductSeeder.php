<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductImage;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dell = Brand::where('name', 'Dell')->first()->id;
        $lenovo = Brand::where('name', 'Lenovo')->first()->id;
        $apple = Brand::where('name', 'Apple')->first()->id;
        $samsung = Brand::where('name', 'Samsung')->first()->id;
        $logitech = Brand::where('name', 'Logitech')->first()->id;
        $kingston = Brand::where('name', 'Kingston')->first()->id;

        $laptops = Category::where('name', 'Laptops')->first()->id;
        $desktops = Category::where('name', 'Desktops')->first()->id;
        $monitors = Category::where('name', 'Monitors')->first()->id;
        $android = Category::where('name', 'Android')->first()->id;
        $ios = Category::where('name', 'iOS')->first()->id;
        $mice = Category::where('name', 'Mice')->first()->id;
        $keyboards = Category::where('name', 'Keyboards')->first()->id;
        $ram = Category::where('name', 'RAM')->first()->id;
        $ssd = Category::where('name', 'SSD')->first()->id;

        $products = [
            // Laptops
            ['name' => 'Dell XPS 15', 'price' => 1299.99, 'description' => 'High performance laptop with stunning display.', 'stock' => 10, 'category_id' => $laptops, 'brand_id' => $dell],
            ['name' => 'Dell Inspiron 15', 'price' => 799.99, 'description' => 'Reliable everyday laptop for work and study.', 'stock' => 15, 'category_id' => $laptops, 'brand_id' => $dell],
            ['name' => 'Lenovo ThinkPad X1', 'price' => 1399.99, 'description' => 'Premium business laptop built for professionals.', 'stock' => 12, 'category_id' => $laptops, 'brand_id' => $lenovo],
            ['name' => 'Lenovo IdeaPad 5', 'price' => 699.99, 'description' => 'Affordable and capable everyday laptop.', 'stock' => 18, 'category_id' => $laptops, 'brand_id' => $lenovo],
            ['name' => 'Apple MacBook Air M2', 'price' => 1099.99, 'description' => 'Thin, light and incredibly fast with Apple M2 chip.', 'stock' => 10, 'category_id' => $laptops, 'brand_id' => $apple],
            ['name' => 'Apple MacBook Pro 14"', 'price' => 1999.99, 'description' => 'Pro performance with M3 chip and Liquid Retina display.', 'stock' => 8, 'category_id' => $laptops, 'brand_id' => $apple],
            // Desktops
            ['name' => 'Dell OptiPlex 7090', 'price' => 899.99, 'description' => 'Compact business desktop with powerful performance.', 'stock' => 10, 'category_id' => $desktops, 'brand_id' => $dell],
            ['name' => 'Lenovo ThinkCentre M70q', 'price' => 749.99, 'description' => 'Tiny but powerful micro desktop for business use.', 'stock' => 8, 'category_id' => $desktops, 'brand_id' => $lenovo],
            // Monitors
            ['name' => 'Samsung 27" 4K Monitor', 'price' => 399.99, 'description' => 'Stunning 4K UHD monitor for work and entertainment.', 'stock' => 15, 'category_id' => $monitors, 'brand_id' => $samsung],
            ['name' => 'Dell UltraSharp 27"', 'price' => 549.99, 'description' => 'Professional monitor with exceptional color accuracy.', 'stock' => 10, 'category_id' => $monitors, 'brand_id' => $dell],
            // Phones
            ['name' => 'Samsung Galaxy S25', 'price' => 799.99, 'description' => 'Latest Samsung flagship with AI features.', 'stock' => 20, 'category_id' => $android, 'brand_id' => $samsung],
            ['name' => 'Samsung Galaxy S25 Ultra', 'price' => 1299.99, 'description' => 'Ultimate Samsung flagship with S Pen and pro camera.', 'stock' => 15, 'category_id' => $android, 'brand_id' => $samsung],
            ['name' => 'iPhone 17', 'price' => 899.99, 'description' => 'The latest iPhone with next generation performance.', 'stock' => 20, 'category_id' => $ios, 'brand_id' => $apple],
            ['name' => 'iPhone 17 Pro', 'price' => 1199.99, 'description' => 'Pro camera system and titanium design.', 'stock' => 15, 'category_id' => $ios, 'brand_id' => $apple],
            // Mice
            ['name' => 'Logitech MX Master 3', 'price' => 99.99, 'description' => 'Advanced wireless mouse for power users.', 'stock' => 25, 'category_id' => $mice, 'brand_id' => $logitech],
            ['name' => 'Logitech G502 Hero', 'price' => 49.99, 'description' => 'High performance wired gaming mouse.', 'stock' => 30, 'category_id' => $mice, 'brand_id' => $logitech],
            ['name' => 'Logitech G502 X Lightspeed Black', 'price' => 149.99, 'description' => 'Wireless gaming mouse with LIGHTSPEED technology.', 'stock' => 20, 'category_id' => $mice, 'brand_id' => $logitech],
            // Keyboards
            ['name' => 'Logitech MX Keys', 'price' => 109.99, 'description' => 'Advanced wireless keyboard for creators.', 'stock' => 20, 'category_id' => $keyboards, 'brand_id' => $logitech],
            ['name' => 'Logitech G413', 'price' => 79.99, 'description' => 'Mechanical gaming keyboard with tactile switches.', 'stock' => 15, 'category_id' => $keyboards, 'brand_id' => $logitech],
            // RAM
            ['name' => 'Kingston 16GB DDR4', 'price' => 49.99, 'description' => 'Reliable 16GB DDR4 3200MHz RAM module.', 'stock' => 40, 'category_id' => $ram, 'brand_id' => $kingston],
            ['name' => 'Kingston 32GB DDR4', 'price' => 89.99, 'description' => 'High capacity 32GB DDR4 3200MHz RAM module.', 'stock' => 30, 'category_id' => $ram, 'brand_id' => $kingston],
            // SSD
            ['name' => 'Samsung 970 EVO 1TB', 'price' => 129.99, 'description' => 'Fast NVMe SSD with 1TB storage capacity.', 'stock' => 35, 'category_id' => $ssd, 'brand_id' => $samsung],
            ['name' => 'Kingston KC3000 1TB', 'price' => 109.99, 'description' => 'High performance PCIe 4.0 NVMe SSD.', 'stock' => 25, 'category_id' => $ssd, 'brand_id' => $kingston],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        Product::factory(150)->create()->each(function($product) {
            ProductImage::create([
                'product_id' => $product->id,
                'image' => 'placeholder.png', // use any existing image as placeholder
                'is_primary' => true,
            ]);
        });
    }
}
