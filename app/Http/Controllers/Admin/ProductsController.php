<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\LookupInterface;
use App\Models\BodyPart;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductsController extends Controller
{
    public function __construct(
        protected LookupInterface $lookup
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->lookup->index();
        return Inertia::render('admin/products/ProductIndex', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/products/ProductNew');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load('translations:body_part_id,language_id,name');
        return Inertia::render('admin/products/ProductEdit', ['body_part' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
