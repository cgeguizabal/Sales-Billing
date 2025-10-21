<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\InventoryTransaction;
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
                $purchase = Purchase::create([
                    'user_id' => $userId,
                    'supplier_id' => $data['supplier_id'],
                    'total' => 0,
                ]);

                $total = 0;

                foreach ($data['details'] as $detail) {
                    $product = Product::findOrFail($detail['product_id']);
                    $unitCost = (float)$product->cost;
                    $quantity = (int)$detail['quantity'];

                    PurchaseDetail::create([
                        'purchase_id' => $purchase->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'unit_cost' => $unitCost,
                    ]);

                    $total += $unitCost * $quantity;
                    $product->increment('stock', $quantity);

                    
                    DB::table('inventory_transactions')->insert([
                        'product_id' => $product->id,
                        'transaction_type' => 'purchase', 
                        'quantity' => $quantity,
                        'transaction_date' => now(),
                        'reference_id' => $purchase->id,
                    ]);
                }

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
                'error' => $e->getMessage(),
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
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}