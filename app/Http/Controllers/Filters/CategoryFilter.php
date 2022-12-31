<?php

namespace App\Http\Controllers\Filters;

use Illuminate\Database\Eloquent\Builder;

class CategoryFilter implements Filter
{
    /**
     *
     * @param Builder $query
     * @return Builder
     */
    public function query(Builder $query): Builder
    {
        return $query->where('category_id', request('category'))->where('approved', 'approved');
    }
}
