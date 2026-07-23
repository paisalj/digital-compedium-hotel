<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// 1. TAMBAHKAN USE INI DI BAGIAN ATAS
use Illuminate\Database\Eloquent\SoftDeletes; 

class Content extends Model
{
    use HasFactory;
    // 2. TAMBAHKAN TRAIT INI DI DALAM CLASS
    use SoftDeletes; 

    protected $fillable = ['category_id', 'icon', 'sort_order', 'is_active'];

    // Relasi ke tabel Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function favorites()
    {
        return $this->hasMany(GuestFavorite::class, 'content_id'); 
        // Sesuaikan nama Model relasinya jika berbeda (misal: GuestFavorite atau Favorite)
    }
    // Relasi ke semua terjemahan milik konten ini
    public function translations()
    {
        return $this->hasMany(ContentTranslation::class);
    }
}