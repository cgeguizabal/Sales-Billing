<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Category;

class Product extends Model
{
   use HasFactory;

    protected $fillable = [
        'category_id',
        'user_id',
        'code',
        'name',
        'description',
        'unit',
        'cost',
        'price',
        'stock',
    ];

    // Relationship: Product belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}