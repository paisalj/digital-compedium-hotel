# Panduan Deploy Menggunakan Docker Compose

# Panduan Awal Deployment & Troubleshooting Laravel di Lingkungan Docker

Dokumen ini berisi langkah-langkah esensial dan solusi dari masalah umum (tampilan rusak, ikon hilang, file upload tidak terbaca) yang sering terjadi saat melakukan *deployment* aplikasi Laravel menggunakan Docker (Nginx/PHP) dan HTTPS.

## 1. Manajemen Build Aset Frontend (Vite)

Saat mem-build aset CSS dan JS menggunakan Node.js di dalam container, sering terjadi masalah hak akses yang membuat web server (Nginx/Apache) tidak bisa membaca file hasil build, sehingga tampilan web menjadi berantakan (Error 404).

**Langkah Penyelesaian:**


1. Lakukan *build* aset menggunakan container Node:

   ```bash
   docker run --rm -v $(pwd)/app4:/app -w /app node:20-alpine sh -c "npm run build"
   ```


2. Kembalikan hak akses folder `public/build` kepada *user* web server (`www-data`):

   ```bash
   docker exec -it app-laravel chown -R www-data:www-data /var/www/html/public/build
   docker exec -it app-laravel chmod -R 755 /var/www/html/public/build
   
   ```

## 2. Mengatasi Ikon Kotak-Kotak (Tofu) & Konflik Font

Setelah mengaktifkan HTTPS, browser sering memblokir file font lokal (Mixed Content) atau Vite gagal mengatur letak (*path*) font dengan benar.

**Solusi Paling Andal (Menggunakan CDN):** Daripada memuat dari file lokal, gunakan CDN untuk *library* ikon (contoh: Bootstrap Icons).


1. Buka file layout utama (misal: `app.blade.php`).
2. Sisipkan tag pemanggil CDN di dalam `<head>`:

   ```markup
   <link rel="stylesheet" href="[https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css](https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css)">
   
   ```
3. **Mencegah Konflik Tailwind:** Jika ikon tidak berupa kotak tetapi **kosong/hilang**, kemungkinan aturan font tertimpa oleh *reset* bawaan Tailwind. Paksa penggunaan font ikon dengan menambahkan blok CSS berikut di bawah link CDN:

   ```markup
   <style>
       .bi, [class^="bi-"], [class*=" bi-"] {
           font-family: bootstrap-icons !important;
           font-style: normal;
           font-weight: normal !important;
           font-variant: normal;
           text-transform: none;
           line-height: 1;
           vertical-align: -0.125em;
           -webkit-font-smoothing: antialiased;
       }
   </style>
   
   ```

## 3. Konfigurasi Folder Storage & Upload Media

Secara bawaan, Laravel menyimpan file unggahan di `storage/app/public`. Folder ini diisolasi dari luar dan tidak bisa dibaca oleh browser sebelum dibuatkan jembatan (*symlink*).

**Langkah-langkah Penautan Storage di Docker:**


1. **Hapus symlink lama (jika ada yang patah):** Symlink yang dibuat di luar container sering kali rusak (*broken link*) karena perbedaan hirarki folder.

   ```bash
   docker exec -it app-laravel rm -rf /var/www/html/public/storage
   
   ```
2. **Buat symlink baru dari dalam container:**

   ```bash
   docker exec -it app-laravel php artisan storage:link
   
   ```
3. **Buka izin tulis/baca folder storage:** Wajib dilakukan agar script PHP bisa menyimpan gambar dan web server bisa menampilkannya.

   ```bash
   docker exec -it app-laravel chown -R www-data:www-data /var/www/html/storage /var/www/html/public/storage
   docker exec -it app-laravel chmod -R 775 /var/www/html/storage /var/www/html/public/storage
   
   ```
4. **Pemanggilan Gambar di HTML (Blade):** Gunakan fungsi `asset()` yang menunjuk ke folder storage publik.

   ```markup
   <img src="{{ asset('storage/' . $item->file_path) }}" alt="Deskripsi">
   
   ```

## 4. Pembersihan Cache (Sapujagat)

Jika Anda sudah mengubah kode, konfigurasi, atau layout tetapi tampilan di browser tidak berubah (bahkan setelah *Hard Reload* `Ctrl + Shift + R`), jalankan perintah pembersihan seluruh memori aplikasi.

```bash
docker exec -it app-laravel php artisan optimize:clear
```