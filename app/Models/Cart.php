<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable =[
        'user_id',
        'ordered_at',
        'is_ordered',
    ];

    protected $appends = ['total_price'];

    public function getTotalPriceAttribute()
    {
        $total =  $this->products->sum(function($cartProduct) {
            return $cartProduct->product->price * $cartProduct->quantity;
        });
        return number_format($total, 2);
    }

    public function products(): HasMany
    {
        return $this->hasMany(CartProduct::class)->with("product");
    }
}
