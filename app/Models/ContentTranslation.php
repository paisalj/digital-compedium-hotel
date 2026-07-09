<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentTranslation extends Model
{
    use HasFactory;

    // Pastikan kolom content_id, language_id, title, slug, dan body terdaftar di sini!
    protected $fillable = [
        'content_id', 
        'language_id', 
        'title', 
        'slug', 
        'body'
    ];

    // Relasi balik ke data induk konten
    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    // Relasi ke data bahasa
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}