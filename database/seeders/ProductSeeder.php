<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Specification;
use App\Models\SpecificationType;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = Brand::pluck('id', 'name');
        $categories = Category::pluck('id', 'name');
        $specTypes = SpecificationType::pluck('id', 'name');

        foreach ($this->catalog() as $entry) {
            $product = Product::create([
                'name' => $entry['name'],
                'price' => $entry['price'],
                'description' => $entry['description'],
                'stock' => $entry['stock'],
                'category_id' => $categories[$entry['category']],
                'brand_id' => $brands[$entry['brand']],
            ]);

            foreach ($entry['specs'] as $type => $value) {
                Specification::create([
                    'product_id' => $product->id,
                    'specification_type_id' => $specTypes[$type],
                    'value' => $value,
                ]);
            }
        }
    }

    /**
     * The full product catalog. Every product carries its own specifications,
     * keyed by specification type name (see SpecificationTypeSeeder).
     */
    private function catalog(): array
    {
        return [
            // ============================== Laptops ==============================
            [
                'name' => 'Dell XPS 15', 'price' => 1299.99, 'stock' => 10,
                'category' => 'Laptops', 'brand' => 'Dell',
                'description' => 'High performance laptop with stunning display.',
                'specs' => [
                    'Processor' => 'Intel Core i7-12700H',
                    'RAM' => '16GB DDR5',
                    'Storage' => '512GB NVMe SSD',
                    'GPU' => 'NVIDIA RTX 3050 Ti',
                    'Display' => '15.6" FHD 144Hz',
                    'OS' => 'Windows 11 Home',
                ],
            ],
            [
                'name' => 'Dell XPS 13', 'price' => 999.99, 'stock' => 12,
                'category' => 'Laptops', 'brand' => 'Dell',
                'description' => 'Ultraportable flagship with InfinityEdge display and all-day battery life.',
                'specs' => [
                    'Processor' => 'Intel Core Ultra 5 125U',
                    'RAM' => '16GB LPDDR5x',
                    'Storage' => '512GB NVMe SSD',
                    'Display' => '13.4" FHD+ InfinityEdge',
                    'Battery' => 'Up to 18 hours',
                    'OS' => 'Windows 11 Home',
                ],
            ],
            [
                'name' => 'Dell Inspiron 15', 'price' => 799.99, 'stock' => 15,
                'category' => 'Laptops', 'brand' => 'Dell',
                'description' => 'Reliable everyday laptop for work and study.',
                'specs' => [
                    'Processor' => 'Intel Core i5-1235U',
                    'RAM' => '8GB DDR4',
                    'Storage' => '256GB SSD',
                    'Display' => '15.6" FHD',
                    'OS' => 'Windows 11 Home',
                ],
            ],
            [
                'name' => 'Dell Latitude 5540', 'price' => 1149.99, 'stock' => 14,
                'category' => 'Laptops', 'brand' => 'Dell',
                'description' => 'Durable business laptop with enterprise security and great keyboard.',
                'specs' => [
                    'Processor' => 'Intel Core i5-1345U',
                    'RAM' => '16GB DDR4',
                    'Storage' => '512GB NVMe SSD',
                    'Display' => '15.6" FHD',
                    'Battery' => 'Up to 14 hours',
                    'OS' => 'Windows 11 Pro',
                ],
            ],
            [
                'name' => 'Dell Vostro 15 3530', 'price' => 599.99, 'stock' => 20,
                'category' => 'Laptops', 'brand' => 'Dell',
                'description' => 'Affordable small business laptop with the essentials done right.',
                'specs' => [
                    'Processor' => 'Intel Core i3-1305U',
                    'RAM' => '8GB DDR4',
                    'Storage' => '256GB NVMe SSD',
                    'Display' => '15.6" FHD 120Hz',
                    'OS' => 'Windows 11 Pro',
                ],
            ],
            [
                'name' => 'Dell Alienware m16 R2', 'price' => 1849.99, 'stock' => 6,
                'category' => 'Laptops', 'brand' => 'Dell',
                'description' => 'Gaming powerhouse with a 240Hz QHD+ display and advanced cooling.',
                'specs' => [
                    'Processor' => 'Intel Core Ultra 7 155H',
                    'RAM' => '16GB DDR5',
                    'Storage' => '1TB NVMe SSD',
                    'GPU' => 'NVIDIA RTX 4070',
                    'Display' => '16" QHD+ 240Hz',
                    'OS' => 'Windows 11 Home',
                ],
            ],
            [
                'name' => 'Lenovo ThinkPad X1', 'price' => 1399.99, 'stock' => 12,
                'category' => 'Laptops', 'brand' => 'Lenovo',
                'description' => 'Premium business laptop built for professionals.',
                'specs' => [
                    'Processor' => 'Intel Core i7-1265U',
                    'RAM' => '16GB DDR5',
                    'Storage' => '512GB NVMe SSD',
                    'Display' => '14" IPS FHD',
                    'OS' => 'Windows 11 Pro',
                ],
            ],
            [
                'name' => 'Lenovo ThinkPad E14 Gen 5', 'price' => 949.99, 'stock' => 16,
                'category' => 'Laptops', 'brand' => 'Lenovo',
                'description' => 'Business essentials with the legendary ThinkPad keyboard at a fair price.',
                'specs' => [
                    'Processor' => 'Intel Core i5-1335U',
                    'RAM' => '16GB DDR4',
                    'Storage' => '512GB NVMe SSD',
                    'Display' => '14" WUXGA IPS',
                    'OS' => 'Windows 11 Pro',
                ],
            ],
            [
                'name' => 'Lenovo IdeaPad 5', 'price' => 699.99, 'stock' => 18,
                'category' => 'Laptops', 'brand' => 'Lenovo',
                'description' => 'Affordable and capable everyday laptop.',
                'specs' => [
                    'Processor' => 'AMD Ryzen 5 5500U',
                    'RAM' => '8GB DDR4',
                    'Storage' => '256GB SSD',
                    'Display' => '15.6" FHD',
                    'OS' => 'Windows 11 Home',
                ],
            ],
            [
                'name' => 'Lenovo Yoga Slim 7', 'price' => 1199.99, 'stock' => 10,
                'category' => 'Laptops', 'brand' => 'Lenovo',
                'description' => 'Sleek creator ultrabook with a vivid 2.8K OLED display.',
                'specs' => [
                    'Processor' => 'AMD Ryzen 7 8845HS',
                    'RAM' => '16GB LPDDR5x',
                    'Storage' => '1TB NVMe SSD',
                    'Display' => '14" 2.8K OLED',
                    'Battery' => 'Up to 15 hours',
                    'OS' => 'Windows 11 Home',
                ],
            ],
            [
                'name' => 'Lenovo Legion 5 Pro', 'price' => 1499.99, 'stock' => 9,
                'category' => 'Laptops', 'brand' => 'Lenovo',
                'description' => 'Serious gaming laptop with a fast WQXGA 165Hz display.',
                'specs' => [
                    'Processor' => 'AMD Ryzen 7 7745HX',
                    'RAM' => '16GB DDR5',
                    'Storage' => '512GB NVMe SSD',
                    'GPU' => 'NVIDIA RTX 4060',
                    'Display' => '16" WQXGA 165Hz',
                    'OS' => 'Windows 11 Home',
                ],
            ],
            [
                'name' => 'Lenovo LOQ 15', 'price' => 899.99, 'stock' => 14,
                'category' => 'Laptops', 'brand' => 'Lenovo',
                'description' => 'Entry level gaming laptop that punches above its price.',
                'specs' => [
                    'Processor' => 'Intel Core i5-13450HX',
                    'RAM' => '16GB DDR5',
                    'Storage' => '512GB NVMe SSD',
                    'GPU' => 'NVIDIA RTX 4050',
                    'Display' => '15.6" FHD 144Hz',
                    'OS' => 'Windows 11 Home',
                ],
            ],
            [
                'name' => 'Apple MacBook Air M2', 'price' => 1099.99, 'stock' => 10,
                'category' => 'Laptops', 'brand' => 'Apple',
                'description' => 'Thin, light and incredibly fast with Apple M2 chip.',
                'specs' => [
                    'Processor' => 'Apple M2',
                    'RAM' => '8GB Unified Memory',
                    'Storage' => '256GB SSD',
                    'Display' => '13.6" Liquid Retina',
                    'Battery' => 'Up to 18 hours',
                    'OS' => 'macOS',
                ],
            ],
            [
                'name' => 'Apple MacBook Air 15" M3', 'price' => 1499.99, 'stock' => 8,
                'category' => 'Laptops', 'brand' => 'Apple',
                'description' => 'The big-screen Air: impossibly thin with a spacious 15" Liquid Retina display.',
                'specs' => [
                    'Processor' => 'Apple M3',
                    'RAM' => '16GB Unified Memory',
                    'Storage' => '512GB SSD',
                    'Display' => '15.3" Liquid Retina',
                    'Battery' => 'Up to 18 hours',
                    'OS' => 'macOS',
                ],
            ],
            [
                'name' => 'Apple MacBook Pro 14"', 'price' => 1999.99, 'stock' => 8,
                'category' => 'Laptops', 'brand' => 'Apple',
                'description' => 'Pro performance with M3 chip and Liquid Retina display.',
                'specs' => [
                    'Processor' => 'Apple M3 Pro',
                    'RAM' => '18GB Unified Memory',
                    'Storage' => '512GB SSD',
                    'Display' => '14.2" Liquid Retina XDR',
                    'Battery' => 'Up to 18 hours',
                    'OS' => 'macOS',
                ],
            ],
            [
                'name' => 'Apple MacBook Pro 16" M3 Max', 'price' => 3499.99, 'stock' => 4,
                'category' => 'Laptops', 'brand' => 'Apple',
                'description' => 'The ultimate creator machine with M3 Max power and an XDR display.',
                'specs' => [
                    'Processor' => 'Apple M3 Max',
                    'RAM' => '36GB Unified Memory',
                    'Storage' => '1TB SSD',
                    'Display' => '16.2" Liquid Retina XDR',
                    'Battery' => 'Up to 22 hours',
                    'OS' => 'macOS',
                ],
            ],
            [
                'name' => 'Samsung Galaxy Book4 Pro', 'price' => 1449.99, 'stock' => 8,
                'category' => 'Laptops', 'brand' => 'Samsung',
                'description' => 'Premium ultrabook with a gorgeous 3K AMOLED touchscreen.',
                'specs' => [
                    'Processor' => 'Intel Core Ultra 7 155H',
                    'RAM' => '16GB LPDDR5x',
                    'Storage' => '512GB NVMe SSD',
                    'Display' => '14" 3K AMOLED Touch 120Hz',
                    'Battery' => 'Up to 17 hours',
                    'OS' => 'Windows 11 Home',
                ],
            ],
            [
                'name' => 'Samsung Galaxy Book4', 'price' => 849.99, 'stock' => 12,
                'category' => 'Laptops', 'brand' => 'Samsung',
                'description' => 'Slim everyday laptop that pairs seamlessly with your Galaxy phone.',
                'specs' => [
                    'Processor' => 'Intel Core i5-1335U',
                    'RAM' => '16GB LPDDR4x',
                    'Storage' => '512GB NVMe SSD',
                    'Display' => '15.6" FHD',
                    'OS' => 'Windows 11 Home',
                ],
            ],

            // ============================== Desktops ==============================
            [
                'name' => 'Dell OptiPlex 7090', 'price' => 899.99, 'stock' => 10,
                'category' => 'Desktops', 'brand' => 'Dell',
                'description' => 'Compact business desktop with powerful performance.',
                'specs' => [
                    'Processor' => 'Intel Core i5-11500',
                    'RAM' => '16GB DDR4',
                    'Storage' => '512GB SSD',
                    'OS' => 'Windows 11 Pro',
                ],
            ],
            [
                'name' => 'Dell OptiPlex Micro 7010', 'price' => 679.99, 'stock' => 12,
                'category' => 'Desktops', 'brand' => 'Dell',
                'description' => 'Palm-sized business PC that hides behind your monitor.',
                'specs' => [
                    'Processor' => 'Intel Core i5-13500T',
                    'RAM' => '8GB DDR4',
                    'Storage' => '256GB NVMe SSD',
                    'OS' => 'Windows 11 Pro',
                ],
            ],
            [
                'name' => 'Dell XPS Desktop 8960', 'price' => 1299.99, 'stock' => 7,
                'category' => 'Desktops', 'brand' => 'Dell',
                'description' => 'Quiet, upgradeable tower for creators and gamers alike.',
                'specs' => [
                    'Processor' => 'Intel Core i7-14700',
                    'RAM' => '16GB DDR5',
                    'Storage' => '512GB NVMe SSD',
                    'GPU' => 'NVIDIA RTX 4060 Ti',
                    'OS' => 'Windows 11 Home',
                ],
            ],
            [
                'name' => 'Dell Alienware Aurora R16', 'price' => 2199.99, 'stock' => 4,
                'category' => 'Desktops', 'brand' => 'Dell',
                'description' => 'Flagship gaming tower with top-tier graphics and liquid cooling.',
                'specs' => [
                    'Processor' => 'Intel Core i9-14900KF',
                    'RAM' => '32GB DDR5',
                    'Storage' => '1TB NVMe SSD',
                    'GPU' => 'NVIDIA RTX 4080 Super',
                    'OS' => 'Windows 11 Home',
                ],
            ],
            [
                'name' => 'Lenovo ThinkCentre M70q', 'price' => 749.99, 'stock' => 8,
                'category' => 'Desktops', 'brand' => 'Lenovo',
                'description' => 'Tiny but powerful micro desktop for business use.',
                'specs' => [
                    'Processor' => 'Intel Core i5-12400T',
                    'RAM' => '16GB DDR4',
                    'Storage' => '512GB SSD',
                    'OS' => 'Windows 11 Pro',
                ],
            ],
            [
                'name' => 'Lenovo IdeaCentre 5', 'price' => 749.99, 'stock' => 10,
                'category' => 'Desktops', 'brand' => 'Lenovo',
                'description' => 'Dependable family desktop for homework, streaming and light editing.',
                'specs' => [
                    'Processor' => 'AMD Ryzen 7 5700G',
                    'RAM' => '16GB DDR4',
                    'Storage' => '512GB NVMe SSD',
                    'GPU' => 'AMD Radeon Graphics',
                    'OS' => 'Windows 11 Home',
                ],
            ],
            [
                'name' => 'Lenovo Legion Tower 5i', 'price' => 1599.99, 'stock' => 6,
                'category' => 'Desktops', 'brand' => 'Lenovo',
                'description' => 'Gaming tower with RGB styling and easy upgrade access.',
                'specs' => [
                    'Processor' => 'Intel Core i7-14700F',
                    'RAM' => '32GB DDR5',
                    'Storage' => '1TB NVMe SSD',
                    'GPU' => 'NVIDIA RTX 4070',
                    'OS' => 'Windows 11 Home',
                ],
            ],
            [
                'name' => 'Lenovo ThinkStation P3 Tower', 'price' => 1899.99, 'stock' => 5,
                'category' => 'Desktops', 'brand' => 'Lenovo',
                'description' => 'ISV-certified workstation for CAD, rendering and data work.',
                'specs' => [
                    'Processor' => 'Intel Core i9-13900',
                    'RAM' => '32GB DDR5',
                    'Storage' => '1TB NVMe SSD',
                    'GPU' => 'NVIDIA T1000 8GB',
                    'OS' => 'Windows 11 Pro',
                ],
            ],
            [
                'name' => 'Apple Mac mini M2', 'price' => 599.99, 'stock' => 15,
                'category' => 'Desktops', 'brand' => 'Apple',
                'description' => 'Compact desktop with M2 speed — just add a display and keyboard.',
                'specs' => [
                    'Processor' => 'Apple M2',
                    'RAM' => '8GB Unified Memory',
                    'Storage' => '256GB SSD',
                    'Connectivity' => 'Thunderbolt 4, HDMI, Wi-Fi 6E',
                    'OS' => 'macOS',
                ],
            ],
            [
                'name' => 'Apple iMac 24" M3', 'price' => 1299.99, 'stock' => 8,
                'category' => 'Desktops', 'brand' => 'Apple',
                'description' => 'Strikingly thin all-in-one with a brilliant 4.5K Retina display.',
                'specs' => [
                    'Processor' => 'Apple M3',
                    'RAM' => '8GB Unified Memory',
                    'Storage' => '256GB SSD',
                    'Display' => '24" 4.5K Retina',
                    'OS' => 'macOS',
                ],
            ],
            [
                'name' => 'Apple Mac Studio M2 Max', 'price' => 1999.99, 'stock' => 5,
                'category' => 'Desktops', 'brand' => 'Apple',
                'description' => 'Studio-grade performance in a compact aluminum enclosure.',
                'specs' => [
                    'Processor' => 'Apple M2 Max',
                    'RAM' => '32GB Unified Memory',
                    'Storage' => '512GB SSD',
                    'Connectivity' => 'Thunderbolt 4, 10Gb Ethernet, HDMI',
                    'OS' => 'macOS',
                ],
            ],

            // ============================== Monitors ==============================
            [
                'name' => 'Samsung 27" 4K Monitor', 'price' => 399.99, 'stock' => 15,
                'category' => 'Monitors', 'brand' => 'Samsung',
                'description' => 'Stunning 4K UHD monitor for work and entertainment.',
                'specs' => [
                    'Resolution' => '3840x2160',
                    'Refresh Rate' => '60Hz',
                    'Panel Type' => 'IPS',
                    'Connectivity' => 'HDMI, DisplayPort',
                ],
            ],
            [
                'name' => 'Samsung Odyssey G5 27"', 'price' => 299.99, 'stock' => 18,
                'category' => 'Monitors', 'brand' => 'Samsung',
                'description' => 'Curved QHD gaming monitor with a fast 165Hz refresh rate.',
                'specs' => [
                    'Resolution' => '2560x1440',
                    'Refresh Rate' => '165Hz',
                    'Panel Type' => 'VA Curved 1000R',
                    'Connectivity' => 'HDMI, DisplayPort',
                ],
            ],
            [
                'name' => 'Samsung Odyssey G9 49"', 'price' => 999.99, 'stock' => 4,
                'category' => 'Monitors', 'brand' => 'Samsung',
                'description' => 'Massive 49" super ultrawide that replaces two QHD monitors.',
                'specs' => [
                    'Resolution' => '5120x1440',
                    'Refresh Rate' => '240Hz',
                    'Panel Type' => 'VA Curved 1000R',
                    'Connectivity' => 'HDMI 2.1, DisplayPort, USB Hub',
                ],
            ],
            [
                'name' => 'Samsung ViewFinity S8 32"', 'price' => 549.99, 'stock' => 9,
                'category' => 'Monitors', 'brand' => 'Samsung',
                'description' => '4K creator monitor with 98% DCI-P3 coverage and USB-C charging.',
                'specs' => [
                    'Resolution' => '3840x2160',
                    'Refresh Rate' => '60Hz',
                    'Panel Type' => 'IPS',
                    'Connectivity' => 'USB-C 90W, HDMI, DisplayPort',
                ],
            ],
            [
                'name' => 'Samsung Smart Monitor M8 32"', 'price' => 649.99, 'stock' => 7,
                'category' => 'Monitors', 'brand' => 'Samsung',
                'description' => '4K smart monitor with built-in streaming apps — no PC required.',
                'specs' => [
                    'Resolution' => '3840x2160',
                    'Refresh Rate' => '60Hz',
                    'Panel Type' => 'VA',
                    'Connectivity' => 'Micro HDMI, USB-C 65W, Wi-Fi',
                ],
            ],
            [
                'name' => 'Dell UltraSharp 27"', 'price' => 549.99, 'stock' => 10,
                'category' => 'Monitors', 'brand' => 'Dell',
                'description' => 'Professional monitor with exceptional color accuracy.',
                'specs' => [
                    'Resolution' => '2560x1440',
                    'Refresh Rate' => '60Hz',
                    'Panel Type' => 'IPS',
                    'Connectivity' => 'HDMI, DisplayPort, USB-C',
                ],
            ],
            [
                'name' => 'Dell UltraSharp 32 4K', 'price' => 899.99, 'stock' => 5,
                'category' => 'Monitors', 'brand' => 'Dell',
                'description' => 'IPS Black 4K display with a full USB-C hub for single-cable setups.',
                'specs' => [
                    'Resolution' => '3840x2160',
                    'Refresh Rate' => '60Hz',
                    'Panel Type' => 'IPS Black',
                    'Connectivity' => 'USB-C 90W Hub, HDMI, DisplayPort, RJ45',
                ],
            ],
            [
                'name' => 'Dell 24 Monitor S2425H', 'price' => 149.99, 'stock' => 25,
                'category' => 'Monitors', 'brand' => 'Dell',
                'description' => 'Crisp FHD office monitor with built-in dual speakers.',
                'specs' => [
                    'Resolution' => '1920x1080',
                    'Refresh Rate' => '100Hz',
                    'Panel Type' => 'IPS',
                    'Connectivity' => 'HDMI x2',
                ],
            ],
            [
                'name' => 'Dell Alienware AW2725DF', 'price' => 599.99, 'stock' => 6,
                'category' => 'Monitors', 'brand' => 'Dell',
                'description' => 'QD-OLED esports monitor with a blistering 360Hz refresh rate.',
                'specs' => [
                    'Resolution' => '2560x1440',
                    'Refresh Rate' => '360Hz',
                    'Panel Type' => 'QD-OLED',
                    'Connectivity' => 'DisplayPort, HDMI',
                ],
            ],
            [
                'name' => 'Lenovo Legion Y27q-30', 'price' => 329.99, 'stock' => 11,
                'category' => 'Monitors', 'brand' => 'Lenovo',
                'description' => 'QHD gaming monitor with 180Hz refresh and low input lag.',
                'specs' => [
                    'Resolution' => '2560x1440',
                    'Refresh Rate' => '180Hz',
                    'Panel Type' => 'IPS',
                    'Connectivity' => 'HDMI, DisplayPort',
                ],
            ],
            [
                'name' => 'Lenovo ThinkVision P27h', 'price' => 429.99, 'stock' => 8,
                'category' => 'Monitors', 'brand' => 'Lenovo',
                'description' => 'Factory-calibrated QHD panel with USB-C docking for the office.',
                'specs' => [
                    'Resolution' => '2560x1440',
                    'Refresh Rate' => '60Hz',
                    'Panel Type' => 'IPS',
                    'Connectivity' => 'USB-C 100W, HDMI, DisplayPort',
                ],
            ],

            // ============================== Phones / Android ==============================
            [
                'name' => 'Samsung Galaxy S25', 'price' => 799.99, 'stock' => 20,
                'category' => 'Android', 'brand' => 'Samsung',
                'description' => 'Latest Samsung flagship with AI features.',
                'specs' => [
                    'Processor' => 'Snapdragon 8 Elite',
                    'RAM' => '12GB',
                    'Storage' => '128GB',
                    'Display' => '6.2" Dynamic AMOLED 120Hz',
                    'Camera' => '50MP + 12MP + 10MP',
                    'Battery' => '4000mAh',
                    'OS' => 'Android 15',
                ],
            ],
            [
                'name' => 'Samsung Galaxy S25+', 'price' => 999.99, 'stock' => 14,
                'category' => 'Android', 'brand' => 'Samsung',
                'description' => 'Bigger display and battery in the same sleek flagship package.',
                'specs' => [
                    'Processor' => 'Snapdragon 8 Elite',
                    'RAM' => '12GB',
                    'Storage' => '256GB',
                    'Display' => '6.7" Dynamic AMOLED 120Hz',
                    'Camera' => '50MP + 12MP + 10MP',
                    'Battery' => '4900mAh',
                    'OS' => 'Android 15',
                ],
            ],
            [
                'name' => 'Samsung Galaxy S25 Ultra', 'price' => 1299.99, 'stock' => 15,
                'category' => 'Android', 'brand' => 'Samsung',
                'description' => 'Ultimate Samsung flagship with S Pen and pro camera.',
                'specs' => [
                    'Processor' => 'Snapdragon 8 Elite',
                    'RAM' => '12GB',
                    'Storage' => '256GB',
                    'Display' => '6.9" Dynamic AMOLED 120Hz',
                    'Camera' => '200MP + 50MP + 10MP + 50MP',
                    'Battery' => '5000mAh',
                    'OS' => 'Android 15',
                ],
            ],
            [
                'name' => 'Samsung Galaxy Z Fold6', 'price' => 1899.99, 'stock' => 5,
                'category' => 'Android', 'brand' => 'Samsung',
                'description' => 'Phone that unfolds into a tablet — multitasking redefined.',
                'specs' => [
                    'Processor' => 'Snapdragon 8 Gen 3',
                    'RAM' => '12GB',
                    'Storage' => '256GB',
                    'Display' => '7.6" Foldable AMOLED 120Hz',
                    'Camera' => '50MP + 12MP + 10MP',
                    'Battery' => '4400mAh',
                    'OS' => 'Android 14',
                ],
            ],
            [
                'name' => 'Samsung Galaxy Z Flip6', 'price' => 1099.99, 'stock' => 8,
                'category' => 'Android', 'brand' => 'Samsung',
                'description' => 'Pocketable flip phone with a handy cover screen.',
                'specs' => [
                    'Processor' => 'Snapdragon 8 Gen 3',
                    'RAM' => '12GB',
                    'Storage' => '256GB',
                    'Display' => '6.7" Foldable AMOLED 120Hz',
                    'Camera' => '50MP + 12MP',
                    'Battery' => '4000mAh',
                    'OS' => 'Android 14',
                ],
            ],
            [
                'name' => 'Samsung Galaxy A56', 'price' => 449.99, 'stock' => 30,
                'category' => 'Android', 'brand' => 'Samsung',
                'description' => 'Mid-range favorite with a large AMOLED display and long battery life.',
                'specs' => [
                    'Processor' => 'Exynos 1580',
                    'RAM' => '8GB',
                    'Storage' => '128GB',
                    'Display' => '6.7" Super AMOLED 120Hz',
                    'Camera' => '50MP + 12MP + 5MP',
                    'Battery' => '5000mAh',
                    'OS' => 'Android 15',
                ],
            ],
            [
                'name' => 'Samsung Galaxy A36', 'price' => 349.99, 'stock' => 35,
                'category' => 'Android', 'brand' => 'Samsung',
                'description' => 'Great value phone with a bright 120Hz screen and all-day battery.',
                'specs' => [
                    'Processor' => 'Snapdragon 6 Gen 3',
                    'RAM' => '6GB',
                    'Storage' => '128GB',
                    'Display' => '6.7" Super AMOLED 120Hz',
                    'Camera' => '50MP + 8MP + 5MP',
                    'Battery' => '5000mAh',
                    'OS' => 'Android 15',
                ],
            ],
            [
                'name' => 'Samsung Galaxy A16', 'price' => 199.99, 'stock' => 40,
                'category' => 'Android', 'brand' => 'Samsung',
                'description' => 'Budget phone with a big AMOLED screen and years of updates.',
                'specs' => [
                    'Processor' => 'Exynos 1330',
                    'RAM' => '4GB',
                    'Storage' => '128GB',
                    'Display' => '6.7" Super AMOLED 90Hz',
                    'Camera' => '50MP + 5MP + 2MP',
                    'Battery' => '5000mAh',
                    'OS' => 'Android 14',
                ],
            ],

            // ============================== Phones / iOS ==============================
            [
                'name' => 'iPhone 17', 'price' => 899.99, 'stock' => 20,
                'category' => 'iOS', 'brand' => 'Apple',
                'description' => 'The latest iPhone with next generation performance.',
                'specs' => [
                    'Processor' => 'Apple A19',
                    'RAM' => '8GB',
                    'Storage' => '128GB',
                    'Display' => '6.1" Super Retina XDR',
                    'Camera' => '48MP + 12MP',
                    'Battery' => 'Up to 22 hours',
                    'OS' => 'iOS 18',
                ],
            ],
            [
                'name' => 'iPhone 17 Pro', 'price' => 1199.99, 'stock' => 15,
                'category' => 'iOS', 'brand' => 'Apple',
                'description' => 'Pro camera system and titanium design.',
                'specs' => [
                    'Processor' => 'Apple A19 Pro',
                    'RAM' => '8GB',
                    'Storage' => '256GB',
                    'Display' => '6.3" Super Retina XDR ProMotion',
                    'Camera' => '48MP + 48MP + 12MP',
                    'Battery' => 'Up to 27 hours',
                    'OS' => 'iOS 18',
                ],
            ],
            [
                'name' => 'iPhone 17 Pro Max', 'price' => 1399.99, 'stock' => 10,
                'category' => 'iOS', 'brand' => 'Apple',
                'description' => 'The biggest Pro iPhone with the longest battery life ever.',
                'specs' => [
                    'Processor' => 'Apple A19 Pro',
                    'RAM' => '12GB',
                    'Storage' => '256GB',
                    'Display' => '6.9" Super Retina XDR ProMotion',
                    'Camera' => '48MP + 48MP + 12MP',
                    'Battery' => 'Up to 33 hours',
                    'OS' => 'iOS 18',
                ],
            ],
            [
                'name' => 'iPhone Air', 'price' => 999.99, 'stock' => 12,
                'category' => 'iOS', 'brand' => 'Apple',
                'description' => 'The thinnest iPhone ever made, without compromising performance.',
                'specs' => [
                    'Processor' => 'Apple A19 Pro',
                    'RAM' => '8GB',
                    'Storage' => '256GB',
                    'Display' => '6.5" Super Retina XDR ProMotion',
                    'Camera' => '48MP Fusion',
                    'Battery' => 'Up to 27 hours',
                    'OS' => 'iOS 18',
                ],
            ],
            [
                'name' => 'iPhone 16', 'price' => 699.99, 'stock' => 18,
                'category' => 'iOS', 'brand' => 'Apple',
                'description' => 'Powerful everyday iPhone with Camera Control and A18 chip.',
                'specs' => [
                    'Processor' => 'Apple A18',
                    'RAM' => '8GB',
                    'Storage' => '128GB',
                    'Display' => '6.1" Super Retina XDR',
                    'Camera' => '48MP + 12MP',
                    'Battery' => 'Up to 22 hours',
                    'OS' => 'iOS 18',
                ],
            ],
            [
                'name' => 'iPhone 16e', 'price' => 599.99, 'stock' => 20,
                'category' => 'iOS', 'brand' => 'Apple',
                'description' => 'The most affordable way to get A18 performance and Apple Intelligence.',
                'specs' => [
                    'Processor' => 'Apple A18',
                    'RAM' => '8GB',
                    'Storage' => '128GB',
                    'Display' => '6.1" Super Retina XDR',
                    'Camera' => '48MP Fusion',
                    'Battery' => 'Up to 26 hours',
                    'OS' => 'iOS 18',
                ],
            ],
            [
                'name' => 'iPhone 15', 'price' => 549.99, 'stock' => 15,
                'category' => 'iOS', 'brand' => 'Apple',
                'description' => 'Proven iPhone with Dynamic Island and a 48MP main camera.',
                'specs' => [
                    'Processor' => 'Apple A16 Bionic',
                    'RAM' => '6GB',
                    'Storage' => '128GB',
                    'Display' => '6.1" Super Retina XDR',
                    'Camera' => '48MP + 12MP',
                    'Battery' => 'Up to 20 hours',
                    'OS' => 'iOS 18',
                ],
            ],

            // ============================== Peripherals / Mice ==============================
            [
                'name' => 'Logitech MX Master 3', 'price' => 99.99, 'stock' => 25,
                'category' => 'Mice', 'brand' => 'Logitech',
                'description' => 'Advanced wireless mouse for power users.',
                'specs' => [
                    'Connectivity' => 'Bluetooth, USB',
                    'DPI' => '200-8000',
                    'Battery' => 'Up to 70 days',
                ],
            ],
            [
                'name' => 'Logitech MX Master 3S', 'price' => 109.99, 'stock' => 22,
                'category' => 'Mice', 'brand' => 'Logitech',
                'description' => 'The productivity flagship, now with quiet clicks and an 8K sensor.',
                'specs' => [
                    'Connectivity' => 'Bluetooth, Logi Bolt',
                    'DPI' => '200-8000',
                    'Battery' => 'Up to 70 days',
                    'Weight' => '141g',
                ],
            ],
            [
                'name' => 'Logitech MX Anywhere 3S', 'price' => 79.99, 'stock' => 18,
                'category' => 'Mice', 'brand' => 'Logitech',
                'description' => 'Compact travel mouse that tracks on any surface, even glass.',
                'specs' => [
                    'Connectivity' => 'Bluetooth, Logi Bolt',
                    'DPI' => '200-8000',
                    'Battery' => 'Up to 70 days',
                    'Weight' => '99g',
                ],
            ],
            [
                'name' => 'Logitech G502 Hero', 'price' => 49.99, 'stock' => 30,
                'category' => 'Mice', 'brand' => 'Logitech',
                'description' => 'High performance wired gaming mouse.',
                'specs' => [
                    'Connectivity' => 'Wired USB',
                    'DPI' => '100-25600',
                    'Weight' => '121g (adjustable)',
                ],
            ],
            [
                'name' => 'Logitech G502 X Lightspeed Black', 'price' => 149.99, 'stock' => 20,
                'category' => 'Mice', 'brand' => 'Logitech',
                'description' => 'Wireless gaming mouse with LIGHTSPEED technology.',
                'specs' => [
                    'Connectivity' => 'Wireless LIGHTSPEED',
                    'DPI' => '100-25600',
                    'Battery' => 'Up to 140 hours',
                    'Weight' => '102g',
                ],
            ],
            [
                'name' => 'Logitech G Pro X Superlight 2', 'price' => 159.99, 'stock' => 12,
                'category' => 'Mice', 'brand' => 'Logitech',
                'description' => 'Esports-grade wireless mouse weighing only 60 grams.',
                'specs' => [
                    'Connectivity' => 'Wireless LIGHTSPEED',
                    'DPI' => '100-32000',
                    'Battery' => 'Up to 95 hours',
                    'Weight' => '60g',
                ],
            ],
            [
                'name' => 'Logitech G305 Lightspeed', 'price' => 49.99, 'stock' => 30,
                'category' => 'Mice', 'brand' => 'Logitech',
                'description' => 'Affordable wireless gaming mouse with the HERO sensor.',
                'specs' => [
                    'Connectivity' => 'Wireless LIGHTSPEED',
                    'DPI' => '200-12000',
                    'Battery' => 'Up to 250 hours (1x AA)',
                    'Weight' => '99g',
                ],
            ],
            [
                'name' => 'Logitech Lift Vertical', 'price' => 69.99, 'stock' => 15,
                'category' => 'Mice', 'brand' => 'Logitech',
                'description' => 'Ergonomic vertical mouse that keeps your wrist at a natural angle.',
                'specs' => [
                    'Connectivity' => 'Bluetooth, Logi Bolt',
                    'DPI' => '400-4000',
                    'Battery' => 'Up to 24 months (1x AA)',
                    'Weight' => '125g',
                ],
            ],
            [
                'name' => 'Logitech M185', 'price' => 19.99, 'stock' => 50,
                'category' => 'Mice', 'brand' => 'Logitech',
                'description' => 'Simple, reliable wireless mouse for everyday use.',
                'specs' => [
                    'Connectivity' => '2.4GHz Wireless (USB receiver)',
                    'DPI' => '1000',
                    'Battery' => 'Up to 12 months (1x AA)',
                    'Weight' => '75g',
                ],
            ],

            // ============================== Peripherals / Keyboards ==============================
            [
                'name' => 'Logitech MX Keys', 'price' => 109.99, 'stock' => 20,
                'category' => 'Keyboards', 'brand' => 'Logitech',
                'description' => 'Advanced wireless keyboard for creators.',
                'specs' => [
                    'Connectivity' => 'Bluetooth, USB',
                    'Switch Type' => 'Scissor',
                    'Battery' => 'Up to 10 days (5 months without backlight)',
                ],
            ],
            [
                'name' => 'Logitech MX Mechanical', 'price' => 169.99, 'stock' => 10,
                'category' => 'Keyboards', 'brand' => 'Logitech',
                'description' => 'Low-profile mechanical typing built for productivity.',
                'specs' => [
                    'Connectivity' => 'Bluetooth, Logi Bolt',
                    'Switch Type' => 'Tactile Quiet Low-Profile',
                    'Battery' => 'Up to 15 days (10 months without backlight)',
                ],
            ],
            [
                'name' => 'Logitech G413', 'price' => 79.99, 'stock' => 15,
                'category' => 'Keyboards', 'brand' => 'Logitech',
                'description' => 'Mechanical gaming keyboard with tactile switches.',
                'specs' => [
                    'Connectivity' => 'Wired USB',
                    'Switch Type' => 'Romer-G Tactile',
                ],
            ],
            [
                'name' => 'Logitech G915 TKL', 'price' => 199.99, 'stock' => 8,
                'category' => 'Keyboards', 'brand' => 'Logitech',
                'description' => 'Premium tenkeyless wireless keyboard with low-profile GL switches.',
                'specs' => [
                    'Connectivity' => 'Wireless LIGHTSPEED, Bluetooth',
                    'Switch Type' => 'GL Tactile Low-Profile',
                    'Battery' => 'Up to 40 hours with RGB',
                ],
            ],
            [
                'name' => 'Logitech G213 Prodigy', 'price' => 59.99, 'stock' => 20,
                'category' => 'Keyboards', 'brand' => 'Logitech',
                'description' => 'Spill-resistant RGB gaming keyboard at an entry-level price.',
                'specs' => [
                    'Connectivity' => 'Wired USB',
                    'Switch Type' => 'Mech-Dome',
                ],
            ],
            [
                'name' => 'Logitech K380', 'price' => 39.99, 'stock' => 40,
                'category' => 'Keyboards', 'brand' => 'Logitech',
                'description' => 'Compact multi-device Bluetooth keyboard that pairs with three devices.',
                'specs' => [
                    'Connectivity' => 'Bluetooth (3 devices)',
                    'Switch Type' => 'Low-Profile Membrane',
                    'Battery' => 'Up to 24 months (2x AAA)',
                ],
            ],
            [
                'name' => 'Logitech Wave Keys', 'price' => 59.99, 'stock' => 14,
                'category' => 'Keyboards', 'brand' => 'Logitech',
                'description' => 'Ergonomic wave-shaped keyboard with a cushioned palm rest.',
                'specs' => [
                    'Connectivity' => 'Bluetooth, Logi Bolt',
                    'Switch Type' => 'Membrane',
                    'Battery' => 'Up to 36 months (2x AAA)',
                ],
            ],
            [
                'name' => 'Logitech POP Keys', 'price' => 99.99, 'stock' => 12,
                'category' => 'Keyboards', 'brand' => 'Logitech',
                'description' => 'Retro round-key mechanical keyboard with swappable emoji keys.',
                'specs' => [
                    'Connectivity' => 'Bluetooth, Logi Bolt',
                    'Switch Type' => 'Mechanical Tactile (Brown)',
                    'Battery' => 'Up to 36 months (2x AAA)',
                ],
            ],

            // ============================== Components / RAM ==============================
            [
                'name' => 'Kingston 16GB DDR4', 'price' => 49.99, 'stock' => 40,
                'category' => 'RAM', 'brand' => 'Kingston',
                'description' => 'Reliable 16GB DDR4 3200MHz RAM module.',
                'specs' => [
                    'Capacity' => '16GB (1x16GB)',
                    'Speed' => 'DDR4-3200 CL22',
                ],
            ],
            [
                'name' => 'Kingston 32GB DDR4', 'price' => 89.99, 'stock' => 30,
                'category' => 'RAM', 'brand' => 'Kingston',
                'description' => 'High capacity 32GB DDR4 3200MHz RAM module.',
                'specs' => [
                    'Capacity' => '32GB (2x16GB)',
                    'Speed' => 'DDR4-3200 CL22',
                ],
            ],
            [
                'name' => 'Kingston Fury Beast 16GB DDR5', 'price' => 69.99, 'stock' => 35,
                'category' => 'RAM', 'brand' => 'Kingston',
                'description' => 'DDR5 gaming memory with low-profile heat spreader and XMP 3.0.',
                'specs' => [
                    'Capacity' => '16GB (1x16GB)',
                    'Speed' => 'DDR5-6000 CL36',
                ],
            ],
            [
                'name' => 'Kingston Fury Beast 32GB DDR5 Kit', 'price' => 124.99, 'stock' => 25,
                'category' => 'RAM', 'brand' => 'Kingston',
                'description' => 'Dual-channel DDR5 kit — the sweet spot for gaming builds.',
                'specs' => [
                    'Capacity' => '32GB (2x16GB)',
                    'Speed' => 'DDR5-5600 CL36',
                ],
            ],
            [
                'name' => 'Kingston Fury Renegade 32GB DDR5', 'price' => 189.99, 'stock' => 12,
                'category' => 'RAM', 'brand' => 'Kingston',
                'description' => 'Extreme-speed DDR5 for overclockers and enthusiast rigs.',
                'specs' => [
                    'Capacity' => '32GB (2x16GB)',
                    'Speed' => 'DDR5-7200 CL38',
                ],
            ],
            [
                'name' => 'Kingston Fury Impact 16GB DDR4 SODIMM', 'price' => 54.99, 'stock' => 28,
                'category' => 'RAM', 'brand' => 'Kingston',
                'description' => 'Plug-and-play laptop memory upgrade with automatic overclocking.',
                'specs' => [
                    'Capacity' => '16GB (1x16GB)',
                    'Speed' => 'DDR4-3200 CL20',
                ],
            ],
            [
                'name' => 'Samsung 16GB DDR5 SODIMM', 'price' => 64.99, 'stock' => 20,
                'category' => 'RAM', 'brand' => 'Samsung',
                'description' => 'OEM-grade DDR5 laptop memory known for stability.',
                'specs' => [
                    'Capacity' => '16GB (1x16GB)',
                    'Speed' => 'DDR5-5600 CL46',
                ],
            ],
            [
                'name' => 'Samsung 8GB DDR4', 'price' => 27.99, 'stock' => 45,
                'category' => 'RAM', 'brand' => 'Samsung',
                'description' => 'Budget-friendly single module for basic desktop upgrades.',
                'specs' => [
                    'Capacity' => '8GB (1x8GB)',
                    'Speed' => 'DDR4-3200 CL22',
                ],
            ],

            // ============================== Components / SSD ==============================
            [
                'name' => 'Samsung 970 EVO 1TB', 'price' => 129.99, 'stock' => 35,
                'category' => 'SSD', 'brand' => 'Samsung',
                'description' => 'Fast NVMe SSD with 1TB storage capacity.',
                'specs' => [
                    'Capacity' => '1TB',
                    'Speed' => '3500MB/s Read',
                    'Interface' => 'PCIe 3.0 NVMe M.2',
                ],
            ],
            [
                'name' => 'Samsung 990 PRO 2TB', 'price' => 199.99, 'stock' => 18,
                'category' => 'SSD', 'brand' => 'Samsung',
                'description' => 'Flagship PCIe 4.0 SSD for gaming and heavy creative workloads.',
                'specs' => [
                    'Capacity' => '2TB',
                    'Speed' => '7450MB/s Read',
                    'Interface' => 'PCIe 4.0 NVMe M.2',
                ],
            ],
            [
                'name' => 'Samsung 990 EVO Plus 1TB', 'price' => 99.99, 'stock' => 22,
                'category' => 'SSD', 'brand' => 'Samsung',
                'description' => 'Efficient everyday NVMe drive with excellent value per gigabyte.',
                'specs' => [
                    'Capacity' => '1TB',
                    'Speed' => '7250MB/s Read',
                    'Interface' => 'PCIe 4.0 NVMe M.2',
                ],
            ],
            [
                'name' => 'Samsung 870 EVO 1TB', 'price' => 89.99, 'stock' => 30,
                'category' => 'SSD', 'brand' => 'Samsung',
                'description' => 'The go-to SATA SSD for reviving older laptops and desktops.',
                'specs' => [
                    'Capacity' => '1TB',
                    'Speed' => '560MB/s Read',
                    'Interface' => 'SATA III 2.5"',
                ],
            ],
            [
                'name' => 'Samsung T7 Shield 2TB', 'price' => 179.99, 'stock' => 15,
                'category' => 'SSD', 'brand' => 'Samsung',
                'description' => 'Rugged portable SSD with IP65 water and dust resistance.',
                'specs' => [
                    'Capacity' => '2TB',
                    'Speed' => '1050MB/s Read',
                    'Interface' => 'USB 3.2 Gen 2 (USB-C)',
                ],
            ],
            [
                'name' => 'Kingston KC3000 1TB', 'price' => 109.99, 'stock' => 25,
                'category' => 'SSD', 'brand' => 'Kingston',
                'description' => 'High performance PCIe 4.0 NVMe SSD.',
                'specs' => [
                    'Capacity' => '1TB',
                    'Speed' => '7000MB/s Read',
                    'Interface' => 'PCIe 4.0 NVMe M.2',
                ],
            ],
            [
                'name' => 'Kingston KC3000 2TB', 'price' => 189.99, 'stock' => 14,
                'category' => 'SSD', 'brand' => 'Kingston',
                'description' => 'Double the capacity of the KC3000 with the same blazing speed.',
                'specs' => [
                    'Capacity' => '2TB',
                    'Speed' => '7000MB/s Read',
                    'Interface' => 'PCIe 4.0 NVMe M.2',
                ],
            ],
            [
                'name' => 'Kingston NV3 1TB', 'price' => 69.99, 'stock' => 40,
                'category' => 'SSD', 'brand' => 'Kingston',
                'description' => 'Affordable NVMe upgrade that still hits 6000MB/s.',
                'specs' => [
                    'Capacity' => '1TB',
                    'Speed' => '6000MB/s Read',
                    'Interface' => 'PCIe 4.0 NVMe M.2',
                ],
            ],
            [
                'name' => 'Kingston A400 480GB', 'price' => 34.99, 'stock' => 50,
                'category' => 'SSD', 'brand' => 'Kingston',
                'description' => 'Entry-level SATA SSD — the cheapest way to ditch a hard drive.',
                'specs' => [
                    'Capacity' => '480GB',
                    'Speed' => '500MB/s Read',
                    'Interface' => 'SATA III 2.5"',
                ],
            ],
            [
                'name' => 'Kingston XS2000 1TB', 'price' => 109.99, 'stock' => 16,
                'category' => 'SSD', 'brand' => 'Kingston',
                'description' => 'Pocket-sized external SSD with up to 2000MB/s transfers.',
                'specs' => [
                    'Capacity' => '1TB',
                    'Speed' => '2000MB/s Read',
                    'Interface' => 'USB 3.2 Gen 2x2 (USB-C)',
                ],
            ],
        ];
    }
}
