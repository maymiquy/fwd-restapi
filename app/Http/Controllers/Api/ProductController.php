<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        if (!empty($products)) {
            return response()->json([
                'message' => 'success',
                'data' => ProductResource::collection($products)
            ], 200);
        } else {
            return response()->json([
                'message' => 'No products found'
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|string|max:100',
            'description' => 'required|string|max:245',
            'price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'error',
                'error' => $validator->errors()
            ]);
        }

        $product = Product::create($input);

        return response()->json([
            'message' => 'success',
            'data' => new ProductResource($product),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);

        if (!empty($product)) {
            return response()->json([
                'message' => 'success',
                'data' => new ProductResource($product)
            ], 200);
        } else {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }
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
