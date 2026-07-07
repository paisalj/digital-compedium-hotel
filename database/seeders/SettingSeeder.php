<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [

            // ==========================
            // HOTEL
            // ==========================

            [
                'key' => 'hotel_name',
                'value' => 'M Bahalap Hotel',
                'type' => 'text',
                'group' => 'hotel',
                'label' => 'Nama Hotel',
                'description' => 'Nama resmi hotel',
                'is_public' => true,
                'sort_order' => 1,
            ],

            [
                'key' => 'hotel_logo',
                'value' => '',
                'type' => 'image',
                'group' => 'hotel',
                'label' => 'Logo Hotel',
                'description' => 'Logo utama hotel',
                'is_public' => true,
                'sort_order' => 2,
            ],

            [
                'key' => 'hotel_description',
                'value' => 'Selamat datang di M Bahalap Hotel.',
                'type' => 'textarea',
                'group' => 'hotel',
                'label' => 'Deskripsi Hotel',
                'description' => 'Deskripsi singkat hotel',
                'is_public' => true,
                'sort_order' => 3,
            ],

            // ==========================
            // CONTACT
            // ==========================

            [
                'key' => 'hotel_phone',
                'value' => '',
                'type' => 'phone',
                'group' => 'contact',
                'label' => 'Nomor Telepon',
                'description' => '',
                'is_public' => true,
                'sort_order' => 4,
            ],

            [
                'key' => 'hotel_email',
                'value' => '',
                'type' => 'email',
                'group' => 'contact',
                'label' => 'Email Hotel',
                'description' => '',
                'is_public' => true,
                'sort_order' => 5,
            ],

            [
                'key' => 'hotel_address',
                'value' => '',
                'type' => 'textarea',
                'group' => 'contact',
                'label' => 'Alamat Hotel',
                'description' => '',
                'is_public' => true,
                'sort_order' => 6,
            ],

            [
                'key' => 'hotel_whatsapp',
                'value' => '',
                'type' => 'phone',
                'group' => 'contact',
                'label' => 'WhatsApp Reception',
                'description' => '',
                'is_public' => true,
                'sort_order' => 7,
            ],

            // ==========================
            // SOCIAL MEDIA
            // ==========================

            [
                'key' => 'instagram',
                'value' => '',
                'type' => 'url',
                'group' => 'social',
                'label' => 'Instagram',
                'description' => '',
                'is_public' => true,
                'sort_order' => 8,
            ],

            [
                'key' => 'facebook',
                'value' => '',
                'type' => 'url',
                'group' => 'social',
                'label' => 'Facebook',
                'description' => '',
                'is_public' => true,
                'sort_order' => 9,
            ],

            [
                'key' => 'youtube',
                'value' => '',
                'type' => 'url',
                'group' => 'social',
                'label' => 'YouTube',
                'description' => '',
                'is_public' => true,
                'sort_order' => 10,
            ],

            // ==========================
            // WEBSITE
            // ==========================

            [
                'key' => 'footer_text',
                'value' => '© M Bahalap Hotel',
                'type' => 'text',
                'group' => 'website',
                'label' => 'Footer Website',
                'description' => '',
                'is_public' => true,
                'sort_order' => 11,
            ],

        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}