<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingTranslation extends Model
{
    use HasFactory;

    // Menyesuaikan kolom dengan yang kita butuhkan untuk sambutan hotel
    protected $fillable = ['setting_id', 'language_id', 'value'];

    // Relasi balik ke data induk Setting (Bukan Category)
    public function setting()
    {
        return $this->belongsTo(Setting::class);
    }

    // Relasi ke data Bahasa yang digunakan (Sama persis)
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}