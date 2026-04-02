<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Specification;
use App\Models\Product;
use App\Models\SpecificationType;

class SpecificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Helper function
        $spec = function($productName, $typeName, $value) {
            $product = Product::where('name', $productName)->first();
            $type = SpecificationType::where('name', $typeName)->first();
            Specification::create([
                'product_id' => $product->id,
                'specification_type_id' => $type->id,
                'value' => $value,
            ]);
        };
        // Dell XPS 15
        $spec('Dell XPS 15', 'Processor', 'Intel Core i7-12700H');
        $spec('Dell XPS 15', 'RAM', '16GB DDR5');
        $spec('Dell XPS 15', 'Storage', '512GB NVMe SSD');
        $spec('Dell XPS 15', 'GPU', 'NVIDIA RTX 3050 Ti');
        $spec('Dell XPS 15', 'Display', '15.6" FHD 144Hz');
        $spec('Dell XPS 15', 'OS', 'Windows 11 Home');

        // Dell Inspiron 15
        $spec('Dell Inspiron 15', 'Processor', 'Intel Core i5-1235U');
        $spec('Dell Inspiron 15', 'RAM', '8GB DDR4');
        $spec('Dell Inspiron 15', 'Storage', '256GB SSD');
        $spec('Dell Inspiron 15', 'Display', '15.6" FHD');
        $spec('Dell Inspiron 15', 'OS', 'Windows 11 Home');

        // Lenovo ThinkPad X1
        $spec('Lenovo ThinkPad X1', 'Processor', 'Intel Core i7-1265U');
        $spec('Lenovo ThinkPad X1', 'RAM', '16GB DDR5');
        $spec('Lenovo ThinkPad X1', 'Storage', '512GB NVMe SSD');
        $spec('Lenovo ThinkPad X1', 'Display', '14" IPS FHD');
        $spec('Lenovo ThinkPad X1', 'OS', 'Windows 11 Pro');

        // Lenovo IdeaPad 5
        $spec('Lenovo IdeaPad 5', 'Processor', 'AMD Ryzen 5 5500U');
        $spec('Lenovo IdeaPad 5', 'RAM', '8GB DDR4');
        $spec('Lenovo IdeaPad 5', 'Storage', '256GB SSD');
        $spec('Lenovo IdeaPad 5', 'Display', '15.6" FHD');
        $spec('Lenovo IdeaPad 5', 'OS', 'Windows 11 Home');

        // Apple MacBook Air M2
        $spec('Apple MacBook Air M2', 'Processor', 'Apple M2');
        $spec('Apple MacBook Air M2', 'RAM', '8GB Unified Memory');
        $spec('Apple MacBook Air M2', 'Storage', '256GB SSD');
        $spec('Apple MacBook Air M2', 'Display', '13.6" Liquid Retina');
        $spec('Apple MacBook Air M2', 'Battery', 'Up to 18 hours');
        $spec('Apple MacBook Air M2', 'OS', 'macOS');

        // Apple MacBook Pro 14"
        $spec('Apple MacBook Pro 14"', 'Processor', 'Apple M3 Pro');
        $spec('Apple MacBook Pro 14"', 'RAM', '18GB Unified Memory');
        $spec('Apple MacBook Pro 14"', 'Storage', '512GB SSD');
        $spec('Apple MacBook Pro 14"', 'Display', '14.2" Liquid Retina XDR');
        $spec('Apple MacBook Pro 14"', 'Battery', 'Up to 18 hours');
        $spec('Apple MacBook Pro 14"', 'OS', 'macOS');

        // Dell OptiPlex 7090
        $spec('Dell OptiPlex 7090', 'Processor', 'Intel Core i5-11500');
        $spec('Dell OptiPlex 7090', 'RAM', '16GB DDR4');
        $spec('Dell OptiPlex 7090', 'Storage', '512GB SSD');
        $spec('Dell OptiPlex 7090', 'OS', 'Windows 11 Pro');

        // Lenovo ThinkCentre M70q
        $spec('Lenovo ThinkCentre M70q', 'Processor', 'Intel Core i5-12400T');
        $spec('Lenovo ThinkCentre M70q', 'RAM', '16GB DDR4');
        $spec('Lenovo ThinkCentre M70q', 'Storage', '512GB SSD');
        $spec('Lenovo ThinkCentre M70q', 'OS', 'Windows 11 Pro');

        // Samsung 27" 4K Monitor
        $spec('Samsung 27" 4K Monitor', 'Resolution', '3840x2160');
        $spec('Samsung 27" 4K Monitor', 'Refresh Rate', '60Hz');
        $spec('Samsung 27" 4K Monitor', 'Connectivity', 'HDMI, DisplayPort');

        // Dell UltraSharp 27"
        $spec('Dell UltraSharp 27"', 'Resolution', '2560x1440');
        $spec('Dell UltraSharp 27"', 'Refresh Rate', '60Hz');
        $spec('Dell UltraSharp 27"', 'Connectivity', 'HDMI, DisplayPort, USB-C');

        // Samsung Galaxy S25
        $spec('Samsung Galaxy S25', 'Processor', 'Snapdragon 8 Elite');
        $spec('Samsung Galaxy S25', 'RAM', '12GB');
        $spec('Samsung Galaxy S25', 'Storage', '128GB');
        $spec('Samsung Galaxy S25', 'Display', '6.2" Dynamic AMOLED 120Hz');
        $spec('Samsung Galaxy S25', 'Camera', '50MP + 12MP + 10MP');
        $spec('Samsung Galaxy S25', 'Battery', '4000mAh');
        $spec('Samsung Galaxy S25', 'OS', 'Android 15');

        // Samsung Galaxy S25 Ultra
        $spec('Samsung Galaxy S25 Ultra', 'Processor', 'Snapdragon 8 Elite');
        $spec('Samsung Galaxy S25 Ultra', 'RAM', '12GB');
        $spec('Samsung Galaxy S25 Ultra', 'Storage', '256GB');
        $spec('Samsung Galaxy S25 Ultra', 'Display', '6.9" Dynamic AMOLED 120Hz');
        $spec('Samsung Galaxy S25 Ultra', 'Camera', '200MP + 50MP + 10MP + 50MP');
        $spec('Samsung Galaxy S25 Ultra', 'Battery', '5000mAh');
        $spec('Samsung Galaxy S25 Ultra', 'OS', 'Android 15');

        // iPhone 17
        $spec('iPhone 17', 'Processor', 'Apple A19');
        $spec('iPhone 17', 'RAM', '8GB');
        $spec('iPhone 17', 'Storage', '128GB');
        $spec('iPhone 17', 'Display', '6.1" Super Retina XDR');
        $spec('iPhone 17', 'Camera', '48MP + 12MP');
        $spec('iPhone 17', 'Battery', 'Up to 22 hours');
        $spec('iPhone 17', 'OS', 'iOS 18');

        // iPhone 17 Pro
        $spec('iPhone 17 Pro', 'Processor', 'Apple A19 Pro');
        $spec('iPhone 17 Pro', 'RAM', '8GB');
        $spec('iPhone 17 Pro', 'Storage', '256GB');
        $spec('iPhone 17 Pro', 'Display', '6.3" Super Retina XDR ProMotion');
        $spec('iPhone 17 Pro', 'Camera', '48MP + 48MP + 12MP');
        $spec('iPhone 17 Pro', 'Battery', 'Up to 27 hours');
        $spec('iPhone 17 Pro', 'OS', 'iOS 18');

        // Logitech MX Master 3
        $spec('Logitech MX Master 3', 'Connectivity', 'Bluetooth, USB');
        $spec('Logitech MX Master 3', 'DPI', '200-8000');

        // Logitech G502 Hero
        $spec('Logitech G502 Hero', 'Connectivity', 'Wired USB');
        $spec('Logitech G502 Hero', 'DPI', '100-25600');

        // Logitech G502 X Lightspeed Black
        $spec('Logitech G502 X Lightspeed Black', 'Connectivity', 'Wireless LIGHTSPEED');
        $spec('Logitech G502 X Lightspeed Black', 'DPI', '100-25600');
        $spec('Logitech G502 X Lightspeed Black', 'Battery', 'Up to 89 hours');

        // Logitech MX Keys
        $spec('Logitech MX Keys', 'Connectivity', 'Bluetooth, USB');
        $spec('Logitech MX Keys', 'Switch Type', 'Scissor');

        // Logitech G413
        $spec('Logitech G413', 'Connectivity', 'Wired USB');
        $spec('Logitech G413', 'Switch Type', 'Romer-G Tactile');

        // Kingston 16GB DDR4
        $spec('Kingston 16GB DDR4', 'Capacity', '16GB');
        $spec('Kingston 16GB DDR4', 'Speed', '3200MHz');

        // Kingston 32GB DDR4
        $spec('Kingston 32GB DDR4', 'Capacity', '32GB');
        $spec('Kingston 32GB DDR4', 'Speed', '3200MHz');

        // Samsung 970 EVO 1TB
        $spec('Samsung 970 EVO 1TB', 'Capacity', '1TB');
        $spec('Samsung 970 EVO 1TB', 'Speed', '3500MB/s Read');

        // Kingston KC3000 1TB
        $spec('Kingston KC3000 1TB', 'Capacity', '1TB');
        $spec('Kingston KC3000 1TB', 'Speed', '7000MB/s Read');

    }


}
