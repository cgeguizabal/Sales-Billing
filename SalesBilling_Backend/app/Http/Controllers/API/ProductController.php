<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
   public function store(Request $request)
{
    $data = $request->validate([
        'code' => 'required|unique:products,code',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'unit' => 'required|string|max:50',
        'cost' => 'required|numeric',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'category' => 'required|string',
    ]);

    $userId = Auth::id();
    if (!$userId) {
        return response()->json(['status'=>false,'message'=>'User not authenticated'], 401);
    }
    $data['user_id'] = $userId;

    $category = Category::firstOrCreate(['name' => $data['category']]);
    $data['category_id'] = $category->id;
    unset($data['category']);

    try {
        $product = Product::create($data);
    } catch (\Exception $e) {
        return response()->json([
            'status'=>false,
            'message'=>'Error creating product',
            'error'=>$e->getMessage(),
            'trace'=>$e->getTraceAsString(),
        ], 500);
    }

    return response()->json([
        'status'=>true,
        'data'=>new ProductResource($product->load('category'))
    ], 201);
}



    public function index()
    {
        $products = Product::with('category')->get();
        return response()->json([
            'status' => true,
            'data' => ProductResource::collection($products)
        ]);
    }




    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return response()->json([
            'status' => true,
            'data' => new ProductResource($product)
        ]);
    }



    
    public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    // Validate input (all fields optional for partial update)
    $data = $request->validate([
        'code' => 'sometimes|unique:products,code,' . $product->id,
        'name' => 'sometimes|string|max:255',
        'description' => 'sometimes|nullable|string',
        'unit' => 'sometimes|string|max:50',
        'cost' => 'sometimes|numeric',
        'price' => 'sometimes|numeric',
        'stock' => 'sometimes|integer',
        'category' => 'sometimes|string|exists:categories,name',
    ]);

    // Convert category name to ID if provided
    if (isset($data['category'])) {
        $category = Category::where('name', $data['category'])->firstOrFail();
        $data['category_id'] = $category->id;
        unset($data['category']); // remove name to avoid mass assignment error
    }

    // Update product
    $product->update($data);

    // Reload relationships
    $product->load('category');

    return response()->json([
        'status' => true,
        'data' => new ProductResource($product)
    ]);
}



    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully'
        ]);
    }
}