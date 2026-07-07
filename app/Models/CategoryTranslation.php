<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['content_id', 'language_id', 'title', 'body', 'slug'];

    // Relasi balik ke data induk Konten
    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    // Relasi ke data Bahasa yang digunakan
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}