<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BodyPart extends Model
{
    protected $fillable =[
      "name",
    ];

    public function translations(): HasMany{
        return $this->hasMany(BodyPartLanguage::class);
    }

    public function products(): BelongsToMany{
        return $this->belongsToMany(Product::class);
    }

}
