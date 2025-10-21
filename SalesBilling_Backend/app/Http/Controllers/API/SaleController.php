<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Customer;
use App\Models\Product;
use App\Models\InventoryTransaction;
use Barryvdh\DomPDF\Facade\Pdf;


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
            return response()->json(['status' => false, 'message' => 'Unauthenticated'], 401);
        }

        try {
            DB::beginTransaction();

            $sale = Sale::create([
                'customer_id' => $data['customer_id'],
                'user_id' => $userId,
                'IVA' => 0,
                'total_before_iva' => 0,
                'total_sale' => 0
            ]);

            $totalBeforeIVA = 0;
            $IVA_PERCENT = 0.13;

            foreach ($data['details'] as $detail) {
                $product = Product::findOrFail($detail['product_id']);
                $quantity = (int)$detail['quantity'];

                if (!isset($product->price) || !isset($product->stock)) {
                    throw new \Exception("Product {$product->id} missing price or stock");
                }

                if ($product->stock < $detail['quantity']) {
                    throw new \Exception("Not enough stock for product {$product->name}");
                }

                $unitPrice = (float)$product->price;
                $subtotal = $unitPrice * $detail['quantity'];
                $totalBeforeIVA += $subtotal;

                $saleDetail = SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $detail['quantity'],
                    'unit_price' => $unitPrice
                ]);

                // Decrease stock
                $product->decrement('stock', $detail['quantity']);

                // Insert inventory transaction (SALE)
                DB::table('inventory_transactions')->insert([
                        'product_id' => $product->id,
                        'transaction_type' => 'sale', 
                        'quantity' => $quantity,
                        'transaction_date' => now(),
                        'reference_id' => $sale->id,
                    ]);
            }

            $ivaAmount = round($totalBeforeIVA * $IVA_PERCENT, 2);
            $totalSale = round($totalBeforeIVA + $ivaAmount, 2);

            $sale->update([
                'IVA' => $ivaAmount,
                'total_before_iva' => $totalBeforeIVA,
                'total_sale' => $totalSale
            ]);

            DB::commit();

            $sale->load('details.product', 'customer');

            return response()->json([
                'status' => true,
                'message' => 'Sale created successfully',
                'data' => $sale
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();

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
            $sales = Sale::with('details.product', 'customer')->get();
            return response()->json(['status' => true, 'data' => $sales]);
        } catch (\Throwable $e) {
            return response()->json(['status' => false, 'message' => 'Failed to fetch sales', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $sale = Sale::with('details.product', 'customer')->findOrFail($id);
            return response()->json(['status' => true, 'data' => $sale]);
        } catch (\Throwable $e) {
            return response()->json(['status' => false, 'message' => 'Sale not found', 'error' => $e->getMessage()], 404);
        }
    }

    public function invoice($id)
{
    try {
        $sale = Sale::with('details.product', 'customer')->findOrFail($id);

        
        $pdf = Pdf::loadView('invoice', compact('sale'));

        
        return $pdf->stream("invoice_{$sale->id}.pdf");
    } catch (\Throwable $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to generate invoice',
            'error' => $e->getMessage()
        ], 500);
    }
}
}