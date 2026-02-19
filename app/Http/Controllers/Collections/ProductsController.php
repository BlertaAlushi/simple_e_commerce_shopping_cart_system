<?php

namespace App\Http\Controllers\Collections;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\ProductsCollectionInterface;
use App\Models\BodyPart;
use App\Models\Extra;
use App\Models\Mark;
use App\Models\ProductType;
use App\Models\SkinConcern;
use App\Models\SkinType;
use App\Services\FilterOptionsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductsController extends Controller
{

    public function __construct(
        protected  ProductsCollectionInterface $productsCollection,
    ){}

    public function all(Request $request) {
        $filters = FilterOptionsService::filters($request);
        $filterOptions = FilterOptionsService::filterOptions();
        $products = $this->productsCollection->products($filters);
        return Inertia::render('Collections', [
            'filters' => $filters,
            'products' => $products,
            'filterOptions' => $filterOptions,
        ]);
    }

    public function filterByBodyPart(Request $request, BodyPart $bodyPart){
        $filters = FilterOptionsService::filters($request);
        $filters["body_parts"]= [$bodyPart->id];
        $filterOptions = FilterOptionsService::filterOptions();
        $products = $this->productsCollection->products($filters);
        unset($filterOptions["body_parts"]);
        return Inertia::render('Collections', [
            'filters' => $filters,
            'products' => $products,
            'filterOptions' => $filterOptions,
        ]);
    }

    public function filterBySkinType(Request $request, SkinType $skinType){
        $filters = FilterOptionsService::filters($request);
        $filters["skin_types"][] = $skinType->id;
        $filterOptions = FilterOptionsService::filterOptions();
        $products = $this->productsCollection->products($filters);
        return Inertia::render('Collections', [
            'filters' => $filters,
            'products' => $products,
            'filterOptions' => $filterOptions,
        ]);
    }

    public function filterBySkinConcern(Request $request, SkinConcern $skinConcern){
        $filters = FilterOptionsService::filters($request);
        $filters["skin_concerns"][] = $skinConcern->id;
        $filterOptions = FilterOptionsService::filterOptions();
        $products = $this->productsCollection->products($filters);
        return Inertia::render('Collections', [
            'filters' => $filters,
            'products' => $products,
            'filterOptions' => $filterOptions,
        ]);
    }

    public function filterByProductType(Request $request, ProductType $productType){
        $filters = FilterOptionsService::filters($request);
        $filters["product_types"][] = $productType->id;
        $filterOptions = FilterOptionsService::filterOptions();
        $products = $this->productsCollection->products($filters);
        return Inertia::render('Collections', [
            'filters' => $filters,
            'products' => $products,
            'filterOptions' => $filterOptions,
        ]);
    }

    public function filterByExtra(Request $request, Extra $extra){
        $filters = FilterOptionsService::filters($request);
        $filters["extras"][] = $extra->id;
        $filterOptions = FilterOptionsService::filterOptions();
        $products = $this->productsCollection->products($filters);
        return Inertia::render('Collections', [
            'filters' => $filters,
            'products' => $products,
            'filterOptions' => $filterOptions,
        ]);
    }

    public function filterByMark(Request $request, Mark $mark){
        $filters = FilterOptionsService::filters($request);
        $filters["marks"] = [$mark->id];
        $filterOptions = FilterOptionsService::filterOptions();
        $products = $this->productsCollection->products($filters);
        unset($filterOptions["marks"]);
        return Inertia::render('Collections', [
            'filters' => $filters,
            'products' => $products,
            'filterOptions' => $filterOptions,
        ]);
    }
}
