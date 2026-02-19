<?php

namespace App\Http\Controllers\Collections;

use App\Http\Controllers\Controller;
use App\Models\BodyPart;
use App\Services\FilterOptionsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductsController extends Controller
{
    public function index(Request $request, $slug){
        $bodyPart = BodyPart::where('slug',$slug)->first();
        $filters = FilterOptionsService::urlQueryFilters($request);
        $products = [];
        $filterOptions = FilterOptionsService::filterOptions();
        return Inertia::render('Collections', [
            'products' => $products,
            'filterOptions'=>$filterOptions,
            'filters' => $filters
        ]);
    }
}
