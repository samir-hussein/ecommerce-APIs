<?php

namespace App\Http\Controllers\Filters;

use Illuminate\Database\Eloquent\Builder;

class BrandFilter implements Filter
{
    /**
     *
     * @param Builder $query
     * @return Builder
     */
    public function query(Builder $query): Builder
    {
        if (request('brand')) {
            return $query->where('brand_id', request('brand'));
        }
    }
}
