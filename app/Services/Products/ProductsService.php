<?php

namespace App\Services\Products;

use App\Interfaces\Services\LookupInterface;
use App\Models\Product;
use App\Services\LookupBaseService;

class ProductsService extends LookupBaseService implements LookupInterface
{
    public function __construct(){
        $this->model = Product::class;
    }
}
