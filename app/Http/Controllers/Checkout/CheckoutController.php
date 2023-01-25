<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use PayMob\PayMob as PayMobPayMob;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $total_price = ProductQuantity::check();

        $order = OrderController::create($request, $total_price);

        OrderController::assignProducts($order);

        // $PaymentKey = PayMobController::pay($total_price, $order->id);

        return response()->json([
            'status' => 'success',
            'data' => [
                'order_id' => $order->id,
                'total_price' => $total_price + 50,
                'currency_type' => 'EGP',
            ]
        ]);
    }

    public function processed(Request $request)
    {
        $request_hmac = $request->hmac;
        $calc_hmac = PayMobPayMob::calcHMAC($request);

        if ($request_hmac == $calc_hmac) {
            $order_id = $request->obj['order']['merchant_order_id'];
            $amount_cents = $request->obj['amount_cents'];
            $transaction_id = $request->obj['id'];

            $order = Order::find($order_id);

            if ($request->obj['success'] == true && ($order->total_price * 100) == $amount_cents) {
                $order->update([
                    'payment_status' => 'finished',
                    'transaction_id' => $transaction_id
                ]);
            } else {
                $order->update([
                    'payment_status' => "failed",
                    'transaction_id' => $transaction_id
                ]);
            }
        }
    }
}
