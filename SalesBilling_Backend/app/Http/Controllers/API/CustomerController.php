<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    // List all customers
    public function index()
    {
        try {
            $customers = Customer::all();

            return response()->json([
                'status' => true,
                'data' => $customers
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch customers',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Store a new customer
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
        ]);

        try {
            $customer = Customer::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Customer created successfully',
                'data' => $customer
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Customer creation failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Show single customer
    public function show($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'status' => false,
                'message' => 'Customer not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $customer
        ]);
    }

    // Update customer
    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'status' => false,
                'message' => 'Customer not found'
            ], 404);
        }

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'contact' => 'sometimes|required|string|max:255',
        ]);

        try {
            $customer->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Customer updated successfully',
                'data' => $customer
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Customer update failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Delete customer
    public function destroy($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'status' => false,
                'message' => 'Customer not found'
            ], 404);
        }

        try {
            $customer->delete();

            return response()->json([
                'status' => true,
                'message' => 'Customer deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Customer deletion failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
