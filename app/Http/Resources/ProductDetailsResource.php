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
        $result = 'false';
        if (auth('customer')->check()) {
            $products = auth('customer')->user()->favorite->pluck('product_id')->toArray();
            $result = (in_array($this->id, $products));
        }

        return [
            'product_id' => $this->id,
            'product_name' => $this->name,
            'product_image' => $this->secure_url,
            'price' => $this->price . " EGP",
            'description' => $this->description,
            'discount' => $this->discount . "%",
            'stock' => ($this->stock > 0) ? "available" : "out of stock",
            'price_after_discount' => $this->finalPrice() . " EGP",
            'favorite' => $result,
            'gallery' => ProductGalleryResource::collection($this->gallery),
            'attributes' => ProductAttributeResource::collection($this->attributes),
            'rating' => $this->rating(),
            'no_of_reviews' => $this->reviews->count(),
            'reviews' => ReviewResource::collection($this->reviews()->latest()->paginate(5))->resource
        ];
    }
}
