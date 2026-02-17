<?php

namespace App\Http\Controllers\Collections;

use App\Http\Controllers\Controller;
use App\Interfaces\Collection\CollectionServiceInterface;
use App\Models\BodyPart;
use App\Services\FilterOptionsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BodyPartsController extends Controller
{
   public function __construct(protected CollectionServiceInterface $collectionService){

   }

   public function index(Request $request, $slug){
       $bodyPart = BodyPart::where('slug',$slug)->first();
       $filters = FilterOptionsService::urlQueryFilters($request);
       $products = $this->collectionService->products($bodyPart,$filters);
       $filterOptions = FilterOptionsService::filterOptions();
       return Inertia::render('Collections', [
           'products' => $products,
           'filterOptions'=>$filterOptions,
           'filters' => $filters
       ]);
   }
}
