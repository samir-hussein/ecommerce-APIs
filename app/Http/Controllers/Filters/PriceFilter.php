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
        if (request('price_from')) {
            return $query->where('price', '>=', request('price_from'))->where('price', '<=', request('price_to'));
        }
    }
}
