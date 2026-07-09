<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model // 👈 Selesai diperbaiki namanya ke Kategori
{
    use HasFactory;

    protected $fillable = ['category_id', 'language_id', 'name', 'slug']; // 👈 Sesuai kolom kategori Anda

    // Relasi balik ke data induk Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke data Bahasa yang digunakan
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}