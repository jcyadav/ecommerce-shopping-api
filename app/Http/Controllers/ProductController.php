<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index()
    {
        $products = Cache::remember('products', 60, function () {
            return Product::all();
        });

        return response()->json($products, 200);
    }

   public function store(Request $request)
{
    $request->validate([
    'title' => 'required|string',
    'slug' => 'required|string|unique:products',
    'price' => 'required|numeric',
    'actual_price' => 'nullable|numeric',
    'discount' => 'nullable|numeric',
    'stock' => 'required|integer',
    'size' => 'nullable|string',
    'color' => 'nullable|string',
    'description' => 'nullable|string',
    'status' => 'boolean',
    'visibility' => 'boolean',
    'category_id' => 'nullable|integer',
    'brand' => 'nullable|string',
    'product_code' => 'nullable|string',
    'product_image' => 'nullable|string',
]);


    $data = $request->all();

    if ($request->hasFile('product_image')) {
        $image = $request->file('product_image');
        $path = $image->store('uploads', 'public');
        $data['product_image'] = $path;
    }

    $product = Product::create($data);

    Cache::forget('products');

    return response()->json([
        'message' => 'Product added successfully',
        'product' => $product
    ], 201);
}


    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        return response()->json($product);
    }

   public function update(Request $request, $id)
{
    $product = Product::find($id);
    if (!$product) {
        return response()->json(['error' => 'Product not found'], 404);
    }

    $request->validate([
        'title' => 'required|string',
        'slug' => 'required|string|unique:products,slug,' . $id,
        'price' => 'required|numeric',
        'actual_price' => 'nullable|numeric',
        'discount' => 'nullable|numeric',
        'stock' => 'required|integer',
        'size' => 'nullable|string',
        'color' => 'nullable|string',
        'description' => 'nullable|string',
        'status' => 'boolean',
        'visibility' => 'boolean',
        'category_id' => 'nullable|integer',
        'brand' => 'nullable|string',
        'product_code' => 'nullable|string',
        'product_image' => 'nullable|string',
    ]);

    $data = $request->all();

    if ($request->hasFile('product_image')) {
        $image = $request->file('product_image');
        $path = $image->store('products', 'public');
        $data['product_image'] = $path;
    }

    if (!$request->has('product_image') && !$request->hasFile('product_image')) {
        $data['product_image'] = $product->product_image;
    }

    $product->update($data);

    Cache::forget('products');

    return response()->json([
        'message' => 'Product updated successfully',
        'product' => $product
    ], 200);
}



    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $product->delete();

        Cache::forget('products');

         return response()->json([
        'message' => 'Product deleted successfully'
    ], 200);
    }
}
