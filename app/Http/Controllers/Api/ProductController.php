<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['vendor', 'category'])->get();
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'vendor_id' => 'required|exists:vendors,id',
            'category_id' => 'required|exists:categories,id',
            'available' => 'boolean'
        ]);

        $product = Product::create($request->all());
        return response()->json($product->load(['vendor', 'category']), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with(['vendor', 'category'])->findOrFail($id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $request->validate([
            'name' => 'string|max:255',
            'description' => 'nullable|string',
            'price' => 'numeric|min:0',
            'vendor_id' => 'exists:vendors,id',
            'category_id' => 'exists:categories,id',
            'available' => 'boolean'
        ]);

        $product->update($request->all());
        return response()->json($product->load(['vendor', 'category']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Get products by vendor.
     */
    public function byVendor($vendorId)
    {
        $products = Product::with(['vendor', 'category'])
            ->where('vendor_id', $vendorId)
            ->get();
        return response()->json($products);
    }

    /**
     * Get products by category.
     */
    public function byCategory($categoryId)
    {
        $products = Product::with(['vendor', 'category'])
            ->where('category_id', $categoryId)
            ->get();
        return response()->json($products);
    }
}
