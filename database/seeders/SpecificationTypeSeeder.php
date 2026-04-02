<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SpecificationType;

class SpecificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Processor', 'RAM', 'Storage', 'GPU', 'Display',
            'Battery', 'OS', 'Connectivity', 'DPI', 'Switch Type',
            'Resolution', 'Refresh Rate', 'Capacity', 'Speed', 'Camera'
        ];
        foreach ($types as $type) {
            SpecificationType::create(['name' => $type]);
        }
    }
}
