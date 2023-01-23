<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\BasicProductResource;
use App\Models\Product\Product;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index()
    {
        $products = Product::where('approved', 'approved')->latest('id')->get();

        $products = BasicProductResource::collection($products);

        $offers = $products->sortByDesc('discount')->take(10)->values();
        $trending = $products->sortByDesc('price')->take(10)->values();
        $new_arrival = $products->take(10);
        $best_seller = $products->sortBy('price')->take(10)->values();
        $top_rated = collect($products)->sortByDesc('rating')->take(10)->values();

        return response()->json([
            "best_offers" => $offers,
            'trending' => $trending,
            'new_arrival' => $new_arrival,
            'best_seller' => $best_seller,
            'top_rated' => $top_rated
        ]);
    }
}
