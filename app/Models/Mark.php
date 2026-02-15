<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    protected $fillable = [
        'name',
        'origin_country',
    ];

    public function products(){
        return $this->hasMany(Product::class);
    }
}
