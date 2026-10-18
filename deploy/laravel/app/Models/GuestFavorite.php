<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestFavorite extends Model
{
    protected $table = 'guest_favorites';
    protected $guarded = [];

    // Relasi balik ke Content jika diperlukan
    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }
}