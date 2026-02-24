<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\ProductsCollectionInterface;
use App\Models\BodyPart;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Laravel\Fortify\Features;

class HomeController extends Controller
{
    public function __construct(
        protected  ProductsCollectionInterface $productsCollection,
    ){}
    public function index(){
        $new_arrivals = $this->productsCollection->newArrivals();
        return Inertia::render('Home', [
            'new_arrivals' => $new_arrivals,
        ]);
    }
}
