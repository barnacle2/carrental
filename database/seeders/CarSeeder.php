<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $cars = [
            [
                'name' => 'Toyota Camry',
                'type' => 'Sedan',
                'transmission' => 'Automatic',
                'price_per_day' => 2500.00,
                'description' => 'Comfortable and reliable sedan perfect for business trips.',
                'image' => 'cars/camry.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Honda CR-V',
                'type' => 'SUV',
                'transmission' => 'Automatic',
                'price_per_day' => 3500.00,
                'description' => 'Spacious SUV ideal for family trips and outdoor adventures.',
                'image' => 'cars/crv.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'BMW M4',
                'type' => 'Sports Car',
                'transmission' => 'Manual',
                'price_per_day' => 8000.00,
                'description' => 'High-performance sports car for an exciting driving experience.',
                'image' => 'cars/m4.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Mercedes-Benz S-Class',
                'type' => 'Luxury',
                'transmission' => 'Automatic',
                'price_per_day' => 10000.00,
                'description' => 'Ultimate luxury sedan with premium features and comfort.',
                'image' => 'cars/s-class.jpg',
                'is_available' => true,
            ],
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }
    }
}
