<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:45',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|unique:suppliers,email',
        ]);

        $supplier = Supplier::create($data);

        return response()->json([
            'status' => true,
            'data' => $supplier
        ], 201);
    }

    public function index()
    {
        $suppliers = Supplier::all();
        return response()->json([
            'status' => true,
            'data' => $suppliers
        ]);
    }

    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);
        return response()->json([
            'status' => true,
            'data' => $supplier
        ]);
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|string|max:45',
            'phone_number' => 'sometimes|string|max:20',
            'email' => 'sometimes|email|unique:suppliers,email,' . $supplier->id,
        ]);

        $supplier->update($data);

        return response()->json([
            'status' => true,
            'data' => $supplier
        ]);
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return response()->json([
            'status' => true,
            'message' => 'Supplier deleted successfully'
        ]);
    }
}