<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\BasicProductResource;

class BrandDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'brand_id' => $this->id,
            'brand_name' => $this->name,
            'products' => BasicProductResource::collection($this->products()->where('approved', 'approved')->latest()->paginate(12))->response()->getData(true),
        ];
    }
}
