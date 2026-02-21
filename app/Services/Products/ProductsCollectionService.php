<?php

namespace App\Services\Products;

use App\Interfaces\Services\ProductsCollectionInterface;
use App\Models\Product;
use App\Resources\Products\ProductResource;

class ProductsCollectionService implements ProductsCollectionInterface
{
    protected array $pivotFilters = [
        'skin_types'     => 'skinTypes',
        'skin_concerns'  => 'skinConcerns',
        'product_types'  => 'productTypes',
        'extras'         => 'extras',
        'body_parts'     => 'bodyParts',
        'marks'          => 'marks',
    ];
    public function products($filters){
        $query = Product::query();

        foreach ($this->pivotFilters as $filterKey => $relation) {
            if (!empty($filters[$filterKey])) {
                if($filterKey == 'marks'){
                    $query->where('mark_id', $filters[$filterKey]);
                }else {
                    $query->whereHas($relation, function ($q) use ($filters, $filterKey) {
                        $q->whereIn('id', $filters[$filterKey]);
                    });
                }
            }
        }

        $products = $query->with('translation:product_id,language_id,name,description')->select('id','slug','price','currency')->get();

        return ProductResource::collection($products);
    }
}
