<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            'status' => true,
            'data' => $categories
        ]);
    }

    /**
     * Store a new category.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $category = Category::create($data);

        return response()->json([
            'status' => true,
            'data' => $category
        ], 201);
    }

    /**
     * Display a single category.
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $category
        ]);
    }

    /**
     * Update a category.
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $data = $request->validate([
    'name' => 'sometimes|string|max:255|unique:categories,name,' . $category->id,

        ]);

        $category->update($data);

        return response()->json([
            'status' => true,
            'data' => $category
        ]);
    }

    /**
     * Delete a category.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully'
        ]);
    }
}