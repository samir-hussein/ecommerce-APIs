<?php

namespace App\Http\Resources\Company;

use App\Http\Resources\Company\CompanyAccountResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CompanyAccountCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return CompanyAccountResource::collection($this->collection);
    }
}
