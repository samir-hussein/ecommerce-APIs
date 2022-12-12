<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $price = ($this->product->price - ($this->product->price * ($this->product->discount / 100)));

        return [
            'item_id' => $this->id,
            'amount' => $this->amount,
            'total_price' => ($price * $this->amount) . " EGP",
            'product' => new BasicProductResource($this->product)
        ];
    }
}
