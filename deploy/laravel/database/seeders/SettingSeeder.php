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
                'key' => 'hotel_logo',
                'value' => '',
                'type' => 'image',
                'group' => 'hotel',
                'label' => 'Logo Hotel',
                'description' => 'Logo utama hotel (tampil di paling atas)',
                'is_public' => true,
                'sort_order' => 1,
            ],

            [
                'key' => 'hotel_name',
                'value' => 'M Bahalap Hotel',
                'type' => 'text',
                'group' => 'hotel',
                'label' => 'Nama Hotel',
                'description' => 'Nama resmi hotel (tampil di bawah logo)',
                'is_public' => true,
                'sort_order' => 2,
            ],

            [
                'key' => 'hotel_welcome_title',
                'value' => 'Selamat Datang di M Bahalap Hotel',
                'type' => 'text',
                'group' => 'hotel',
                'label' => 'Judul Selamat Datang',
                'description' => 'Teks utama sambutan (Teks Tebal)',
                'is_public' => true,
                'sort_order' => 3,
            ],

            [
                'key' => 'hotel_description',
                'value' => 'Merupakan suatu kehormatan bagi kami menerima Anda di sini...',
                'type' => 'textarea',
                'group' => 'hotel',
                'label' => 'Deskripsi Sambutan',
                'description' => 'Teks paragraf di bawah garis pembatas',
                'is_public' => true,
                'sort_order' => 4,
            ],

            [
                'key' => 'hotel_background',
                'value' => '',
                'type' => 'image',
                'group' => 'hotel',
                'label' => 'Background Utama',
                'description' => 'Gambar latar belakang halaman depan tamu',
                'is_public' => true,
                'sort_order' => 5,
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
                'sort_order' => 5,
            ],

            [
                'key' => 'hotel_email',
                'value' => '',
                'type' => 'email',
                'group' => 'contact',
                'label' => 'Email Hotel',
                'description' => '',
                'is_public' => true,
                'sort_order' => 6,
            ],

            [
                'key' => 'hotel_address',
                'value' => '',
                'type' => 'textarea',
                'group' => 'contact',
                'label' => 'Alamat Hotel',
                'description' => '',
                'is_public' => true,
                'sort_order' => 7,
            ],

            [
                'key' => 'hotel_whatsapp',
                'value' => '',
                'type' => 'phone',
                'group' => 'contact',
                'label' => 'WhatsApp Reception',
                'description' => '',
                'is_public' => true,
                'sort_order' => 8,
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
                'sort_order' => 9,
            ],

            [
                'key' => 'facebook',
                'value' => '',
                'type' => 'url',
                'group' => 'social',
                'label' => 'Facebook',
                'description' => '',
                'is_public' => true,
                'sort_order' => 10,
            ],

            [
                'key' => 'youtube',
                'value' => '',
                'type' => 'url',
                'group' => 'social',
                'label' => 'YouTube',
                'description' => '',
                'is_public' => true,
                'sort_order' => 11,
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
                'sort_order' => 12,
            ],

        ];

        // 👇 Mengubah create menjadi updateOrCreate agar tidak duplikat saat dijalankan ulang 👇
        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']], // Cari berdasarkan 'key'
                $setting // Update atau buat baru dengan data ini
            );
        }
    }
}