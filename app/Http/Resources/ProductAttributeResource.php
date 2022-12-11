<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductAttributeResource extends JsonResource
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
            'attribute_id' => $this->id,
            'attribute_name' => $this->attr_name,
            'attribute_values' => ProductAttributeValueResource::collection($this->values)
        ];
    }
}
