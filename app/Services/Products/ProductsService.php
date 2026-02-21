<?php

namespace App\Services\Products;

use App\Interfaces\Services\LookupInterface;
use App\Models\Product;
use App\Resources\Products\ProductResource;
use App\Services\LookupBaseService;

class ProductsService extends LookupBaseService implements LookupInterface
{
    public function __construct(){
        $this->model = Product::class;
    }

    public function index(){
        $products = $this->model::with('mark:id,name')->get();
        return ProductResource::collection($products);
    }
}
