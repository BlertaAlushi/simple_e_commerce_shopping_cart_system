<?php

namespace App\Services;
use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public static function cartProductCount(){
       return Auth::user()->cartProducts()->sum('quantity');
    }

    public function addToCart($data){

    }
}
