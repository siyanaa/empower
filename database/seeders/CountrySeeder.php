<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            [
                'name' => 'Work in UAE',
                'image' => json_encode([
                    'uploads/country/Australia_1.webp',
                    'uploads/country/Australia_2.webp',
                ]),
                'content' => 'This is the content'
            ],
            [
                'name' => 'Work in Qatar',
                'image' => json_encode([
                    'uploads/country/USA_1.webp',
                    'uploads/country/USA_2.webp',
                ]),
                'content' => 'This is the content'
            ],
            [
                'name' => 'Work in Malaysia',
                'image' => json_encode([
                    'uploads/country/Canada_1.webp',
                    'uploads/country/Canada_2.webp',
                ]),
                'content' => 'This is the content'
            ],
            [
                'name' => 'Work in Kuwait',
                'image' => json_encode([
                    'uploads/country/UK_1.webp',
                    'uploads/country/UK_2.webp',
                ]),
                'content' => 'This is the content'
            ],
            [
                'name' => 'Work in Europe',
                'image' => json_encode([
                    'uploads/country/Europe_1.webp',
                    'uploads/country/Europe_2.webp',
                ]),
                'content' => 'This is the content'
            ]


        ];
        foreach ($countries as $countryData) {
            // Generate a unique slug
            $slug = Str::slug($countryData['name']);
            // Check if the slug already exists
            $count = Country::where('slug', $slug)->count();
            if ($count > 0) {
                // Append a unique suffix to the slug
                $slug = $slug . '-' . ($count + 1);
            }
            // Create the country with the generated slug
            Country::create(array_merge($countryData, ['slug' => $slug]));
        }
    }
}
