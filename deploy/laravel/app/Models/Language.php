<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'name',

        'code',

        'native_name',

        'flag',

        'is_default',

        'is_active',

        'sort_order',

    ];

    protected $casts = [

        'is_default' => 'boolean',

        'is_active'  => 'boolean',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function categoryTranslations(): HasMany
    {
        return $this->hasMany(CategoryTranslation::class);
    }
}