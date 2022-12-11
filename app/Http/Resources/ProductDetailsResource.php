<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailsResource extends JsonResource
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
            'product_id' => $this->id,
            'product_name' => $this->name,
            'product_image' => $this->secure_url,
            'price' => $this->price . " EGP",
            'description' => $this->description,
            'discount' => $this->discount . "%",
            'stock' => ($this->stock > 0) ? "available" : "out of stock",
            'price_after_discount' => ($this->price - ($this->price * ($this->discount / 100))) . " EGP",
            'gallery' => ProductGalleryResource::collection($this->gallery),
            'attributes' => ProductAttributeResource::collection($this->attributes),
            'rating' => "soon",
            'reviews' => "soon"
        ];
    }
}
