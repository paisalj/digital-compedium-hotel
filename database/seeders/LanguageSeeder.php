<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Language::insert([

            [

                'name' => 'Bahasa Indonesia',

                'code' => 'id',

                'native_name' => 'Bahasa Indonesia',

                'flag' => '🇮🇩',

                'is_default' => true,

                'is_active' => true,

                'sort_order' => 1,

                'created_at' => now(),

                'updated_at' => now(),

            ],

            [

                'name' => 'English',

                'code' => 'en',

                'native_name' => 'English',

                'flag' => '🇺🇸',

                'is_default' => false,

                'is_active' => true,

                'sort_order' => 2,

                'created_at' => now(),

                'updated_at' => now(),

            ],

            [

                'name' => 'Dayak Ngaju',

                'code' => 'djk',

                'native_name' => 'Dayak Ngaju',

                'flag' => '🟤',

                'is_default' => false,

                'is_active' => true,

                'sort_order' => 3,

                'created_at' => now(),

                'updated_at' => now(),

            ],

        ]);
    }
}