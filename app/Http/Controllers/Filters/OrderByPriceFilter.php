<?php

namespace App\Http\Controllers\Filters;

use App\Http\Controllers\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class OrderByPriceFilter implements Filter
{
    /**
     *
     * @param Builder $query
     * @return Builder
     */
    public function query(Builder $query): Builder
    {
        if (request('orderByPrice')) {
            $order = (request('orderByPrice') == 'high') ? 'desc' : 'asc';
            return $query->orderBy('price', $order);
        }
    }
}
