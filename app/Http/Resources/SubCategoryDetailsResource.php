<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryDetailsResource extends JsonResource
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
            'sub_category_id' => $this->id,
            'sub_category_name' => $this->name,
            'category_id' => $this->category_id,
            'brands' => BrandResource::collection($this->brands)
        ];
    }
}
