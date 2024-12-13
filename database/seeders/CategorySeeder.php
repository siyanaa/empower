<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['title' => 'Guiding Principles'],
            ['title' => 'Living Abroad'],
            // ['title' => 'Counselling'],
            // ['title' => 'News'],
            // ['title' => 'Country University']
        ];
        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
