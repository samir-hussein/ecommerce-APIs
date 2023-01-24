<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $total_price = ProductQuantity::check();

        $order = OrderController::create($request, $total_price);

        OrderController::assignProducts($order);

        return response()->json([
            'status' => 'success',
            'data' => [
                'order_id' => $order->id,
                'total_price' => $total_price,
                'currency_type' => 'EGP'
            ]
        ]);
    }
}
