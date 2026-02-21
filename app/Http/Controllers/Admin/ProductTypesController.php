<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\LookupInterface;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductTypesController extends Controller
{
    public function __construct(
        protected LookupInterface $lookup
    ){}
    public function index(){
        $product_types = $this->lookup->index();
        return Inertia::render('admin/product_types/ProductTypeIndex', ['product_types' => $product_types]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/product_types/ProductTypeCreate');
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
    public function edit(ProductType $productType)
    {
        $productType->load('translations:product_type_id,language_id,name');
        return Inertia::render('admin/product_types/ProductTypeEdit', ['product_type' => $productType]);
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
    }
}
