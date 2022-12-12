<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'review_id' => $this->id,
            'comment' => $this->comment,
            'rating' => $this->rating,
            'product_id' => $this->product_id,
            'customer' => new CustomerAccountResource($this->customer)
        ];
    }
}
