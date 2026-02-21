<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\LookupInterface;
use App\Models\BodyPart;
use App\Models\Extra;
use App\Models\Mark;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\SkinConcern;
use App\Models\SkinType;
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
        return Inertia::render('admin/products/ProductNew', [
            'marks' => Mark::all(),
            'bodyParts' => BodyPart::all(),
            'productTypes' => ProductType::all(),
            'skinTypes' => SkinType::all(),
            'skinConcerns' => SkinConcern::all(),
            'extras' => Extra::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'price' => 'required|numeric',
            'currency' => 'required|string',
            'stock_quantity' => 'required|integer',
            'mark_id' => 'required|exists:marks,id',
            'image' => 'nullable|image'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('products', 'public');
        }

        $product = Product::create($validated);

        // translations
        foreach ($request->translations as $translation) {
            $product->translations()->create($translation);
        }

        // sync relations
        $product->bodyParts()->sync($request->body_parts);
        $product->productTypes()->sync($request->product_types);
        $product->skinTypes()->sync($request->skin_types);
        $product->skinConcerns()->sync($request->skin_concerns);
        $product->extras()->sync($request->extras);

        return redirect()->route('admin.products.index');
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
        $product->load([
            'translations',
            'bodyParts',
            'productTypes',
            'skinTypes',
            'skinConcerns',
            'extras'
        ]);
        return Inertia::render('admin/products/ProductEdit', [
            'product' => $product,
            'marks' => Mark::all(),
            'bodyParts' => BodyPart::all(),
            'productTypes' => ProductType::all(),
            'skinTypes' => SkinType::all(),
            'skinConcerns' => SkinConcern::all(),
            'extras' => Extra::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->only([
            'price', 'currency', 'stock_quantity', 'mark_id'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('products', 'public');
        }

        $product->update($data);

        foreach ($request->translations as $translation) {
            $product->translations()->updateOrCreate(
                ['language_id' => $translation['language_id']],
                [
                    'name' => $translation['name'],
                    'description' => $translation['description']
                ]
            );
        }

        $product->bodyParts()->sync($request->body_parts);
        $product->productTypes()->sync($request->product_types);
        $product->skinTypes()->sync($request->skin_types);
        $product->skinConcerns()->sync($request->skin_concerns);
        $product->extras()->sync($request->extras);

        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
