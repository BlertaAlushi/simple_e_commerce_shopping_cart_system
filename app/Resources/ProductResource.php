<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'slug' => $this->slug,
            'price' => $this->price,
            'currency' => $this->currency,
            'translation' => $this->translation ? [
                'name' => $this->translation->name,
                'description' => $this->translation->description,
                ] : null,
        ];
    }
}
