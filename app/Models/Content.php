<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'icon', 'sort_order', 'is_active'];

    // Relasi ke tabel Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke semua terjemahan milik konten ini
    public function translations()
    {
        return $this->hasMany(ContentTranslation::class);
    }
}