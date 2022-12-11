<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'category_id' => $this->id,
            'category_name' => $this->name,
            'sub_categories' => SubCategoryResource::collection($this->subCategories),
            'brands' => BrandResource::collection($this->brands),
            'products' => BasicProductResource::collection($this->products()->paginate(12))->response()->getData(true),
        ];
    }
}
