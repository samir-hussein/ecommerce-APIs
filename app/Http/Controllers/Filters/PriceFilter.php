<?php

namespace App\Http\Controllers\Filters;

use Illuminate\Database\Eloquent\Builder;

class PriceFilter implements Filter
{
    /**
     *
     * @param Builder $query
     * @return Builder
     */
    public function query(Builder $query): Builder
    {
        if (request('price')) {
            return $query->whereBetween('price', request('price'));
        }
    }
}
