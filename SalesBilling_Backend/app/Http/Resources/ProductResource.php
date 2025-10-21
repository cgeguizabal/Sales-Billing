<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
   public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'unit' => $this->unit,
            'cost' => $this->cost,
            'price' => $this->price,
            'stock' => $this->stock,
            'category' => $this->category ? $this->category->name : null,
        ];
    }
}