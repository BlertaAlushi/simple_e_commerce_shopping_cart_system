<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SkinConcern extends Model
{
    protected $fillable =[
        "name",
    ];

    public function translations(): HasMany{
        return $this->hasMany(SkinConcernLanguage::class);
    }

    public function products(): BelongsToMany{
        return $this->belongsToMany(Product::class);
    }
}
