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
            'drug_name' => $this->drug_name,
            'chemical_name' => $this->chemical_name,
            'manufacturer_country' => $this->manufacturer_country,
            'manufacturer_company' => $this->manufacturer_company,
            'distribution_company' => $this->distribution_company,
            'expire_date' => $this->expire_date,
            'original_price' => $this->original_price,
            'selling_price' => $this->selling_price,
            'quantity' => $this->quantity,
            'user_id' => $this->user_id,
        ];
    }
}
