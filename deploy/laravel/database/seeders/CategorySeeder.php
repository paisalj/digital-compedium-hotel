<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [

            [
                'name' => 'Welcome',
                'icon' => 'bi-house-door',
                'sort_order' => 1,
            ],

            [
                'name' => 'Hotel Information',
                'icon' => 'bi-building',
                'sort_order' => 2,
            ],

            [
                'name' => 'Restaurant',
                'icon' => 'bi-cup-hot',
                'sort_order' => 3,
            ],

            [
                'name' => 'Room Service',
                'icon' => 'bi-bell',
                'sort_order' => 4,
            ],

            [
                'name' => 'Facilities',
                'icon' => 'bi-stars',
                'sort_order' => 5,
            ],

            [
                'name' => 'Laundry',
                'icon' => 'bi-basket',
                'sort_order' => 6,
            ],

            [
                'name' => 'WiFi',
                'icon' => 'bi-wifi',
                'sort_order' => 7,
            ],

            [
                'name' => 'Gallery',
                'icon' => 'bi-images',
                'sort_order' => 8,
            ],

            [
                'name' => 'Emergency Contact',
                'icon' => 'bi-telephone',
                'sort_order' => 9,
            ],

        ];

        foreach ($categories as $category) {

            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'icon' => $category['icon'],
                'sort_order' => $category['sort_order'],
            ]);

        }
    }
}