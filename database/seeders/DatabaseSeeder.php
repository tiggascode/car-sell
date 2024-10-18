<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarImage;
use App\Models\CarType;
use App\Models\City;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\Model;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        CarType::factory()
            ->sequence(
                ['name' => 'Sedan'],
                ['name' => 'Hatchback'],
                ['name' => 'SUV'],
                ['name' => 'Pickup Truck'],
                ['name' => 'Minivan'],
                ['name' => 'Jeep'],
                ['name' => 'Coupe'],
                ['name' => 'Crossover'],
                ['name' => 'Sports Car']
            )
            ->count(9)
            ->create();

        FuelType::factory()
            ->sequence(
                ['name' => 'Gasoline'],
                ['name' => 'Diesel'],
                ['name' => 'Electric'],
                ['name' => 'Hybrid']
            )
            ->count(4)
            ->create();

        $states = [
            'California' => ['Los Angeles', 'San Francisco', 'San Diego'],
            'Texas' => ['Houston', 'Dallas', 'Austin'],
            'Florida' => ['Miami', 'Tampa', 'Orlando'],
            'New York' => ['New York City', 'Buffalo', 'Rochester'],
            'Illinois' => ['Chicago', 'Springfield', 'Peoria'],
            'Pennsylvania' => ['Philadelphia', 'Pittsburgh', 'Allentown'],
            'Ohio' => ['Columbus', 'Cleveland', 'Cincinnati'],
            'Georgia' => ['Atlanta', 'Augusta', 'Savannah'],
            'North Carolina' => ['Charlotte', 'Raleigh', 'Greensboro'],
            'Michigan' => ['Detroit', 'Grand Rapids', 'Lansing'],
        ];

        foreach ($states as $state => $cities) {
            State::factory()
                ->state(['name' => $state])
                ->has(
                    City::factory()
                        ->count(count($cities))
                        ->sequence(...array_map(fn($city) => ['name' => $city], $cities))
                )->create();
        }

        $makers = [
            'Toyota' => ['Corolla', 'Camry', 'Avalon', 'Rav4'],
            'Ford' => ['Fusion', 'Mustang', 'Explorer', 'F-150'],
            'Honda' => ['Civic', 'Accord', 'CR-V', 'Pilot'],
            'Chevrolet' => ['Silverado', 'Cruze', 'Equinox', 'Bolt'],
            'Nissan' => ['Altima', 'Sentra', 'Rogue', 'GT-R'],
            'Lexus' => ['ES', 'GS', 'RX', 'NX'],
        ];
        foreach ($makers as $maker => $models) {
            Maker::factory()
                ->state(['name' => $maker])
                ->has(
                    Model::factory()
                        ->count(count($models))
                        ->sequence(...array_map(fn($model) => ['name' => $model], $models))
                )->create();
        }

        User::factory()
            ->count(3)
            ->create();

        User::factory()
            ->count(2)
            ->has(
                Car::factory()
                    ->count(50)
                    ->has(
                        CarImage::factory()
                            ->count(5)
                            ->sequence(fn(Sequence $sequence) => ['position' => $sequence->index % 5 + 1]),
                        'images'
                    )
                    ->hasFeatures(),
                'favouriteCars'
            )
            ->create();

    }
}
