<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index()
    {
        try {
            $inventory = DB::table('inventory_transactions')
                ->leftJoin('products', 'inventory_transactions.product_id', '=', 'products.id')
                ->select(
                    'inventory_transactions.id',
                    'products.name as product_name', // <- use actual column name here
                    'inventory_transactions.transaction_type',
                    'inventory_transactions.quantity',
                    'inventory_transactions.transaction_date',
                    'inventory_transactions.reference_id'
                )
                ->get();

            if ($inventory->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No inventory transactions found'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'data' => $inventory
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error fetching inventory transactions',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}