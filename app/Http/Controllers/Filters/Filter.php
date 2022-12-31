<?php

namespace App\Http\Controllers\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface Filter
{
    /**
     *
     * @param Builder $query
     * @return Builder|Collection|void
     */
    public function query(Builder $query);
}
