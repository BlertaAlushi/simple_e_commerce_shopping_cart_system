<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductType extends Model
{
    protected $fillable =[
        "name",
    ];

    public function translations(): HasMany{
        return $this->hasMany(ProductTypeLanguage::class);
    }

    public function products(): BelongsToMany{
        return $this->belongsToMany(Product::class);
    }
}
