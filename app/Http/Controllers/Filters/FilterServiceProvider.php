<?php

namespace App\Http\Controllers\Filters;

use App\Helpers\CollectionPaginate;
use App\Http\Resources\BasicProductResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

class FilterServiceProvider
{
    private static $filters = [
        'category' => CategoryFilter::class,
        'sub_category' => SubCategoryFilter::class,
        'brand' => BrandFilter::class,
        'rating' => RatingFilter::class,
        'price_from' => PriceFilter::class,
        'orderByPrice' => OrderByPriceFilter::class,
        'discount' => DiscountFilter::class,
    ];

    public static function boot(Builder $query, array $filters)
    {
        $filterRating = false;

        foreach ($filters as $filter) {
            if (in_array($filter, array_keys(self::$filters))) {
                if ($filter == 'rating') {
                    $filterRating = true;
                    continue;
                }
                $obj = new self::$filters["$filter"];
                $query = $obj->query($query);
            }
        }

        if ($filterRating) {
            $obj = new self::$filters["rating"];
            $query = $obj->query($query);

            if ($query) {
                return CollectionPaginate::paginate(collect(BasicProductResource::collection($query))->sortByDesc('rating')->values(), 12);
            } else return response()->json([
                "current_page" => 1,
                'data' => [],
                "first_page_url" => request()->fullUrl() . "&page=1",
                "from" => null,
                "last_page" => 1,
                "last_page_url" => request()->fullUrl() . "&page=1",
                "next_page_url" => null,
                "path" => Paginator::resolveCurrentPath(),
                "per_page" => 12,
                "prev_page_url" => null,
                'to' => null,
                "total" => 0
            ]);
        }

        return BasicProductResource::collection($query->latest('id')->paginate(12)->withQueryString())->resource;
    }
}
