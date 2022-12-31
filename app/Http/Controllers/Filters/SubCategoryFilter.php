<?php

namespace App\Http\Controllers\Filters;

use Illuminate\Database\Eloquent\Builder;

class SubCategoryFilter implements Filter
{
    /**
     *
     * @param Builder $query
     * @return Builder
     */
    public function query(Builder $query): Builder
    {
        if (request('sub_category')) {
            return $query->where('sub_category_id', request('sub_category'));
        }
    }
}
