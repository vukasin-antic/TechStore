<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductImage;
use App\Models\Product;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = function($productName, $files) {
            $product = Product::where('name', $productName)->first();
            foreach ($files as $index => $file) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $file,
                    'is_primary' => $index === 0,
                ]);
            }
        };

        $images('Dell XPS 15', ['Dell-XPS-15-1.avif', 'Dell-XPS-15-2.avif', 'Dell-XPS-15-3.avif', 'Dell-XPS-15-4.avif']);
        $images('Dell Inspiron 15', ['Dell-Inspiron-15-1.avif', 'Dell-Inspiron-15-2.avif', 'Dell-Inspiron-15-3.avif', 'Dell-Inspiron-15-4.avif']);
        $images('Lenovo ThinkPad X1', ['Lenovo-ThinkPad-X1-1.avif', 'Lenovo-ThinkPad-X1-2.avif', 'Lenovo-ThinkPad-X1-3.avif', 'Lenovo-ThinkPad-X1-4.avif']);
        $images('Lenovo IdeaPad 5', ['Lenovo-IdeaPad-5-1.avif', 'Lenovo-IdeaPad-5-2.avif', 'Lenovo-IdeaPad-5-3.avif', 'Lenovo-IdeaPad-5-4.avif']);
        $images('Apple MacBook Air M2', ['Apple-MacBook-Air-M2-1.webp', 'Apple-MacBook-Air-M2-2.webp', 'Apple-MacBook-Air-M2-3.webp', 'Apple-MacBook-Air-M2-4.webp']);
        $images('Apple MacBook Pro 14"', ['Apple-MacBook-Pro-14-1.webp', 'Apple-MacBook-Pro-14-2.webp', 'Apple-MacBook-Pro-14-3.webp', 'Apple-MacBook-Pro-14-4.webp']);
        $images('Dell OptiPlex 7090', ['Dell-OptiPlex-7090-1.avif', 'Dell-OptiPlex-7090-2.avif', 'Dell-OptiPlex-7090-3.avif', 'Dell-OptiPlex-7090-4.avif']);
        $images('Lenovo ThinkCentre M70q', ['Lenovo-ThinkCentre-M70q-1.avif', 'Lenovo-ThinkCentre-M70q-2.avif', 'Lenovo-ThinkCentre-M70q-3.avif', 'Lenovo-ThinkCentre-M70q-4.avif']);
        $images('Samsung 27" 4K Monitor', ['Samsung-27-Monitor-1.avif', 'Samsung-27-Monitor-2.avif', 'Samsung-27-Monitor-3.avif']);
        $images('Dell UltraSharp 27"', ['Dell-UltraSharp-27-1.webp', 'Dell-UltraSharp-27-2.webp', 'Dell-UltraSharp-27-3.webp', 'Dell-UltraSharp-27-4.webp']);
        $images('Samsung Galaxy S25', ['Samsung-Galaxy-S25-1.webp', 'Samsung-Galaxy-S25-2.webp', 'Samsung-Galaxy-S25-3.webp']);
        $images('Samsung Galaxy S25 Ultra', ['Samsung-Galaxy-S25-Ultra-1.webp', 'Samsung-Galaxy-S25-Ultra-2.webp', 'Samsung-Galaxy-S25-Ultra-3.webp']);
        $images('iPhone 17', ['iPhone-17-1.webp', 'iPhone-17-2.webp', 'iPhone-17-3.webp', 'iPhone-17-4.webp']);
        $images('iPhone 17 Pro', ['iPhone-17-Pro-1.webp', 'iPhone-17-Pro-2.webp', 'iPhone-17-Pro-3.webp', 'iPhone-17-Pro-4.webp']);
        $images('Logitech MX Master 3', ['Logitech-MX-Master-3-1.webp', 'Logitech-MX-Master-3-2.webp', 'Logitech-MX-Master-3-3.webp', 'Logitech-MX-Master-3-4.webp']);
        $images('Logitech G502 Hero', ['Logitech-G502-Hero-1.webp', 'Logitech-G502-Hero-2.webp', 'Logitech-G502-Hero-3.webp', 'Logitech-G502-Hero-4.webp']);
        $images('Logitech G502 X Lightspeed Black', ['Logitech-G502-X-LIGHTSPEED-1.webp', 'Logitech-G502-X-LIGHTSPEED-2.webp', 'Logitech-G502-X-LIGHTSPEED-3.webp', 'Logitech-G502-X-LIGHTSPEED-4.webp']);
        $images('Logitech MX Keys', ['Logitech-MX-Keys-1.webp', 'Logitech-MX-Keys-2.webp', 'Logitech-MX-Keys-3.webp']);
        $images('Logitech G413', ['Logitech-G413-1.webp', 'Logitech-G413-2.webp', 'Logitech-G413-3.webp', 'Logitech-G413-4.webp']);
        $images('Kingston 16GB DDR4', ['Kingston-16GB-DDR4-1.webp', 'Kingston-16GB-DDR4-2.webp', 'Kingston-16GB-DDR4-3.webp']);
        $images('Kingston 32GB DDR4', ['Kingston-32GB-DDR4-1.webp', 'Kingston-32GB-DDR4-2.webp', 'Kingston-32GB-DDR4-3.webp']);
        $images('Samsung 970 EVO 1TB', ['Samsung-970-EVO-1TB-1.webp', 'Samsung-970-EVO-1TB-2.webp', 'Samsung-970-EVO-1TB-3.webp', 'Samsung-970-EVO-1TB-4.webp']);
        $images('Kingston KC3000 1TB', ['Kingston-KC3000-1TB-1.webp', 'Kingston-KC3000-1TB-2.webp', 'Kingston-KC3000-1TB-3.webp']);

    }
}
