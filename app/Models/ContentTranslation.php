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

    /*
    |--------------------------------------------------------------------------
    | AUTOMATIC ACTIVITY LOG (TAMBAHKAN BAGIAN INI) ⭐
    |--------------------------------------------------------------------------
    */
    protected static function booted()
    {
        static::created(function ($translation) {
            ActivityLog::create([
                'user_id'     => auth()->id(),
                'module'      => 'Content',
                'action'      => 'CREATE',
                'description' => "Content ID {$translation->content_id} telah di-create",
                'ip_address'  => request()->ip(),
            ]);
        });

        static::updated(function ($translation) {
            ActivityLog::create([
                'user_id'     => auth()->id(),
                'module'      => 'Content',
                'action'      => 'UPDATE',
                'description' => "Content ID {$translation->content_id} telah di-update",
                'ip_address'  => request()->ip(),
            ]);
        });

        static::deleted(function ($translation) {
            ActivityLog::create([
                'user_id'     => auth()->id(),
                'module'      => 'Content',
                'action'      => 'DELETE',
                'description' => "Content ID {$translation->content_id} telah di-delete",
                'ip_address'  => request()->ip(),
            ]);
        });
    }

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