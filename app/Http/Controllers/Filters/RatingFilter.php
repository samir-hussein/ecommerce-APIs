<?php

namespace App\Http\Controllers\Filters;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class RatingFilter implements Filter
{
    /**
     *
     * @param Builder $query
     * @return Builder|Collection|void
     */
    public function query(Builder $query)
    {
        if (request('rating')) {
            return $query->get()->reject(function ($product) {
                return ($product->rating() < request('rating'));
            });
        }
    }
}
