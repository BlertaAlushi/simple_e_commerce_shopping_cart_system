<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductsController extends Controller
{
    public function index(Request $request){
        $products = Product::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(8)
            ->withQueryString();

        return Inertia::render('admin/Products', [
            'products_array' => $products,
            'filters' => $request->only('search'),
        ]);
    }


}
