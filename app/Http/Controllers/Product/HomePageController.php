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
        $top_rated = collect($products)->sortByDesc('rating')->take(10)->values();
        $best_seller = BasicProductResource::collection(Product::query()
            ->join('order_products', 'order_products.product_id', '=', 'products.id')
            ->selectRaw('products.*, SUM(order_products.quantity) AS quantity_sold')
            ->groupBy(['products.id'])
            ->orderByDesc('quantity_sold')
            ->take(10)
            ->get());

        return response()->json([
            "best_offers" => $offers,
            'trending' => $trending,
            'new_arrival' => $new_arrival,
            'best_seller' => $best_seller,
            'top_rated' => $top_rated
        ]);
    }
}
