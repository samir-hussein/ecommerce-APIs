<?php

namespace App\Http\Controllers\Filters;

use Illuminate\Database\Eloquent\Builder;

class DiscountFilter implements Filter
{
    /**
     *
     * @param Builder $query
     * @return Builder
     */
    public function query(Builder $query): Builder
    {
        if (request('discount')) {
            return $query->where('discount', '>=', request('discount'))->orderBy('discount', 'desc');
        }
    }
}
