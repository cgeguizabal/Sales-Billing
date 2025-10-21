<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product; 

class InventoryTransaction extends Model
{
    use HasFactory;

    protected $table = 'inventory_transactions';

    protected $fillable = [
        'product_id',
        'transaction_type', 
        'quantity',
        'transaction_date',
        'reference_id', 
    ];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}