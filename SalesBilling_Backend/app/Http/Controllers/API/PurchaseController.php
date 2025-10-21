<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'details' => 'required|array|min:1',
            'details.*.product_id' => 'required|exists:products,id',
            'details.*.quantity' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();
        if (!$userId) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        try {
            return DB::transaction(function () use ($data, $userId) {
                // Create purchase
                $purchase = Purchase::create([
                    'user_id' => $userId,
                    'supplier_id' => $data['supplier_id'],
                    'total' => 0,
                ]);

                $total = 0;

                foreach ($data['details'] as $detail) {
                    $product = Product::find($detail['product_id']);
                    if (!$product) {
                        throw new \Exception("Product ID {$detail['product_id']} not found");
                    }

                    // Create purchase detail with unit cost
                    PurchaseDetail::create([
                        'purchase_id' => $purchase->id,
                        'product_id' => $product->id,
                        'quantity' => $detail['quantity'],
                        'unit_cost' => (float)$product->cost, // <-- NEW
                    ]);

                    // Calculate subtotal
                    $subtotal = $detail['quantity'] * (float)$product->cost;
                    $total += $subtotal;

                    // Update stock
                    $product->increment('stock', $detail['quantity']);
                }

                // Update total purchase
                $purchase->update(['total' => $total]);

                return response()->json([
                    'status' => true,
                    'message' => 'Purchase created successfully',
                    'data' => $purchase->load('details.product', 'supplier'),
                ], 201);
            });
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Purchase creation failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        try {
            $purchases = Purchase::with('supplier', 'details.product')->get();

            return response()->json([
                'status' => true,
                'data' => $purchases,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch purchases',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}