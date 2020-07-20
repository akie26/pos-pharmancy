<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Product;

class ProductResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'item_name' => $this->item_name,
            'brand' => $this->brand,
            'size' => $this->size,
            'detail' => $this->detail,
            'barcode' => $this->barcode,
            'original_price' => $this->original_price,
            'selling_price' => $this->selling_price,
            'quantity' => $this->quantity,
            'user_id' => $this->user_id,
        ];
    }
}
