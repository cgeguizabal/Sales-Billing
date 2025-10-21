<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
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
                // Create sale
                $sale = Sale::create([
                    'customer_id' => $data['customer_id'],
                    'user_id' => $userId,
                    'IVA' => 0,
                    'total_before_iva' => 0,
                    'total_sale' => 0,
                ]);

                $totalBeforeIVA = 0;
                $IVA_PERCENT = 0.13;

                foreach ($data['details'] as $detail) {
                    $product = Product::find($detail['product_id']);
                    if (!$product) {
                        throw new \Exception("Product ID {$detail['product_id']} not found");
                    }

                    if ($product->stock < $detail['quantity']) {
                        throw new \Exception("Not enough stock for product {$product->name}");
                    }

                    $unitPrice = (float)$product->price;
                    $subtotal = $unitPrice * $detail['quantity'];
                    $totalBeforeIVA += $subtotal;

                    // Create sale detail
                    SaleDetail::create([
                        'sale_id' => $sale->id,
                        'product_id' => $product->id,
                        'quantity' => $detail['quantity'],
                        'unit_price' => $unitPrice,
                    ]);

                    // Decrement stock
                    $product->decrement('stock', $detail['quantity']);
                }

                $ivaAmount = round($totalBeforeIVA * $IVA_PERCENT, 2);
                $totalSale = round($totalBeforeIVA + $ivaAmount, 2);

                // Update totals
                $sale->update([
                    'IVA' => $ivaAmount,
                    'total_before_iva' => $totalBeforeIVA,
                    'total_sale' => $totalSale,
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Sale created successfully',
                    'data' => $sale->load('details.product', 'customer'),
                ], 201);
            });
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Sale creation failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        try {
            $sales = Sale::with('customer', 'details.product')->get();
            return response()->json([
                'status' => true,
                'data' => $sales,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch sales',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $sale = Sale::with('customer', 'details.product')->findOrFail($id);
            return response()->json([
                'status' => true,
                'data' => $sale,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Sale not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}