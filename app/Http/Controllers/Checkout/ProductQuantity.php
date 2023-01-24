<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Resources\BasicProductResource;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductQuantity
{
    public static function check()
    {
        $products = auth()->user()->cart;
        $notEnough = [];
        $total_price = 0;

        if (count($products) == 0) {
            throw new HttpResponseException(response()->json([
                'state' => 'error',
                'message' => 'There is no products in your cart.',
            ]));
        }

        foreach ($products as $product) {
            $unit_price = ((100 - $product->product->discount) / 100) * $product->product->price;
            $total_price += $unit_price * $product->amount;
            if ($product->amount > $product->product->stock) {
                $notEnough[] = new BasicProductResource($product->product);
            }
        }

        if ($notEnough) {
            throw new HttpResponseException(response()->json([
                'state' => 'error',
                'message' => 'Products quantity unavailable.',
                'products_quantity_unavailable' => $notEnough
            ]));
        }

        return round($total_price);
    }
}
