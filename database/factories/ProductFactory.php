<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\Brand;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Coherent brand + category + model combinations so generated
     * products look like real tech store items instead of lorem ipsum.
     */
    private const BLUEPRINTS = [
        ['brand' => 'Dell', 'category' => 'Laptops', 'price' => [549, 1899], 'models' => ['Dell Inspiron 14 5445', 'Dell Latitude 3550', 'Dell Vostro 16 5640', 'Dell Inspiron 16 Plus']],
        ['brand' => 'Lenovo', 'category' => 'Laptops', 'price' => [449, 1799], 'models' => ['Lenovo ThinkBook 14 Gen 6', 'Lenovo IdeaPad Slim 3', 'Lenovo Legion Slim 5', 'Lenovo Yoga 7 2-in-1']],
        ['brand' => 'Samsung', 'category' => 'Laptops', 'price' => [699, 1599], 'models' => ['Samsung Galaxy Book4 Edge', 'Samsung Galaxy Book3 360']],
        ['brand' => 'Dell', 'category' => 'Desktops', 'price' => [499, 1999], 'models' => ['Dell Inspiron Desktop 3030', 'Dell OptiPlex Tower 7020']],
        ['brand' => 'Lenovo', 'category' => 'Desktops', 'price' => [449, 1799], 'models' => ['Lenovo ThinkCentre neo 50t', 'Lenovo IdeaCentre Mini']],
        ['brand' => 'Dell', 'category' => 'Monitors', 'price' => [129, 899], 'models' => ['Dell 27 Monitor S2725DS', 'Dell P2723QE']],
        ['brand' => 'Samsung', 'category' => 'Monitors', 'price' => [119, 999], 'models' => ['Samsung Odyssey G3 24"', 'Samsung Essential S3 27"']],
        ['brand' => 'Lenovo', 'category' => 'Monitors', 'price' => [109, 549], 'models' => ['Lenovo L27i-40', 'Lenovo ThinkVision T24i']],
        ['brand' => 'Samsung', 'category' => 'Android', 'price' => [149, 1299], 'models' => ['Samsung Galaxy S24 FE', 'Samsung Galaxy A26', 'Samsung Galaxy XCover 7']],
        ['brand' => 'Apple', 'category' => 'iOS', 'price' => [449, 1299], 'models' => ['iPhone 16 Plus', 'iPhone 15 Plus', 'iPhone 14']],
        ['brand' => 'Logitech', 'category' => 'Mice', 'price' => [14, 159], 'models' => ['Logitech G403 Hero', 'Logitech M330 Silent Plus', 'Logitech M720 Triathlon']],
        ['brand' => 'Logitech', 'category' => 'Keyboards', 'price' => [19, 199], 'models' => ['Logitech K120', 'Logitech Signature K650', 'Logitech G613']],
        ['brand' => 'Kingston', 'category' => 'RAM', 'price' => [24, 249], 'models' => ['Kingston ValueRAM 8GB DDR4', 'Kingston Fury Beast 64GB DDR5 Kit']],
        ['brand' => 'Samsung', 'category' => 'RAM', 'price' => [29, 179], 'models' => ['Samsung 32GB DDR5']],
        ['brand' => 'Kingston', 'category' => 'SSD', 'price' => [29, 249], 'models' => ['Kingston NV3 2TB', 'Kingston A400 960GB']],
        ['brand' => 'Samsung', 'category' => 'SSD', 'price' => [59, 299], 'models' => ['Samsung 980 1TB', 'Samsung T9 2TB']],
    ];

    private const DESCRIPTIONS = [
        'Laptops' => [
            'Well balanced laptop for everyday work, school and entertainment.',
            'Slim and lightweight laptop with long battery life.',
            'Dependable laptop with fast SSD storage and a crisp display.',
        ],
        'Desktops' => [
            'Reliable desktop PC for home and office tasks.',
            'Compact desktop with plenty of ports and quiet cooling.',
            'Expandable tower ready for future upgrades.',
        ],
        'Monitors' => [
            'Sharp display with thin bezels, ideal for multi-monitor setups.',
            'Comfortable viewing with flicker-free technology and low blue light mode.',
            'Vivid colors and wide viewing angles for work and play.',
        ],
        'Android' => [
            'Capable Android smartphone with a great camera and battery life.',
            'Sleek Android phone with a smooth high refresh rate display.',
            'Durable smartphone with expandable storage and 5G support.',
        ],
        'iOS' => [
            'Reliable iPhone experience with regular software updates.',
            'Great camera, all-day battery and the familiar iOS ecosystem.',
        ],
        'Mice' => [
            'Comfortable mouse with precise tracking for everyday use.',
            'Responsive mouse with customizable buttons.',
            'Smooth and quiet mouse that fits either hand.',
        ],
        'Keyboards' => [
            'Comfortable keyboard with quiet, responsive keys.',
            'Durable keyboard with spill-resistant design.',
            'Full-size keyboard built for long typing sessions.',
        ],
        'RAM' => [
            'Dependable memory upgrade for smoother multitasking.',
            'Tested for stability and backed by a lifetime warranty.',
        ],
        'SSD' => [
            'Fast storage upgrade that cuts loading times dramatically.',
            'Reliable solid state drive with excellent value per gigabyte.',
        ],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $blueprint = fake()->randomElement(self::BLUEPRINTS);

        return [
            'name' => fake()->randomElement($blueprint['models']),
            'price' => fake()->numberBetween($blueprint['price'][0], $blueprint['price'][1]) - 0.01,
            'description' => fake()->randomElement(self::DESCRIPTIONS[$blueprint['category']]),
            'stock' => fake()->numberBetween(0, 50),
            'category_id' => Category::where('name', $blueprint['category'])->first()->id,
            'brand_id' => Brand::where('name', $blueprint['brand'])->first()->id,
        ];
    }
}
