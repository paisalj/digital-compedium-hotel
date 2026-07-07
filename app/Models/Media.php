<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'mime_type',
        'alt_text',
        'sort_order',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    /**
     * Konten induk media.
     */
    public function content(): BelongsTo
    {
        return $this->belongsTo(Content::class);
    }
}