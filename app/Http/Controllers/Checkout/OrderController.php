<?php

namespace App\Http\Controllers\Checkout;

use App\Models\BillingAddress;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

class OrderController
{
    public function index()
    {
        return response()->json([
            'data' => auth()->user()->orders
        ]);
    }

    public static function create(Request $request, float $total_price)
    {
        $validated = Validator::make($request->all(), [
            'payment_type' => 'required|in:cash,visa',
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|numeric',
        ]);

        if ($validated->fails()) {
            throw new HttpResponseException(response()->json([
                'state' => 'error',
                'message' => $validated->errors(),
            ]));
        }

        $order = Order::create([
            'payment_type' => $request->payment_type,
            'total_price' => $total_price,
            'customer_id' => auth()->id()
        ]);

        $request->request->add([
            'order_id' => $order->id
        ]);

        self::assignAddress($request->except('payment_type'));

        return $order;
    }

    public static function assignProducts($order)
    {
        $products = auth()->user()->cart;
        $order_products = [];

        foreach ($products as $product) {
            $unit_price = ((100 - $product->product->discount) / 100) * $product->product->price;
            $total_price = $unit_price * $product->amount;

            $temp = [
                'order_id' => $order->id,
                'product_id' => $product->product_id,
                'quantity' => $product->amount,
                'price' => $total_price,
            ];
            $order_products[] = $temp;

            $product->product->decrement('stock', $product->amount);
            $product->delete();
        }

        OrderProduct::insert($order_products);
    }

    private static function assignAddress(array $data)
    {
        BillingAddress::create($data);
    }
}
