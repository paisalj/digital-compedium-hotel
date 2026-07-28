<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'module',      // <--- Tambahkan ini
        'action',
        'description',
        'ip_address',
        'user_agent',  // (Opsional, jika Anda ingin menyimpannya)
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    /**
     * User yang melakukan aktivitas.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR (TAMBAHAN BARU DI SINI) ⭐
    |--------------------------------------------------------------------------
    */

    /**
     * Mengubah teks "ID 7" menjadi "(Nama Item)" secara otomatis.
     */
public function getFormattedDescriptionAttribute()
    {
        $text = $this->description;

        // 1. Cari apakah ada kata "ID" diikuti angka, contoh: "ID 21"
        if (preg_match('/ID\s+(\d+)/i', $text, $matches)) {
            $id = $matches[1];
            $module = trim($this->module); // Hapus spasi berlebih
            $itemName = null;

            // 2. Khusus untuk Modul Content, cari judulnya dari tabel ContentTranslation
            if ($module === 'Content' || $module === 'Contents') {
                $translation = \App\Models\ContentTranslation::where('content_id', $id)->first();
                if ($translation) {
                    $itemName = $translation->title;
                }
            } 
            
            // 3. Untuk modul lain (Category, Language, dll) cari langsung ke modelnya
            else {
                $modelMap = [
                    'Category' => 'Category',
                    'Language' => 'Language',
                ];

                $modelName = $modelMap[$module] ?? str_replace(' ', '', $module);
                $modelClass = "\\App\\Models\\" . $modelName;

                if (class_exists($modelClass)) {
                    $item = $modelClass::find($id);
                    if ($item) {
                        $itemName = $item->name ?? $item->title ?? $item->judul ?? $item->nama ?? null;
                    }
                }
            }

            // 4. Jika nama/judul berhasil ditemukan, ganti teks "ID [angka]" dengan nama aslinya
            if ($itemName) {
                return str_replace("ID $id", "($itemName)", $text);
            } else {
                // Jika datanya kosong atau sudah terhapus
                return str_replace("ID $id", "(ID $id - Terhapus)", $text);
            }
        }

        // Jika tidak ada kata ID, tampilkan teks asli
        return $text;
    }    
    
    }
