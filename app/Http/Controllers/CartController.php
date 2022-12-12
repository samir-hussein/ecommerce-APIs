<?php

namespace App\Http\Controllers;

use App\Http\Middleware\EnsureCartOwner;
use App\Http\Requests\Cart\CartStoreRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer')->only(['store', 'index']);

        $this->middleware(['auth:customer', 'EnsureCartOwner'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->totalCartPrice();
        $items = $response['items'];

        return response()->json(
            CartResource::collection($items)->additional([
                'total_items' => $items->sum('amount'),
                'total_price' => $response['total_price'] . " EGP"
            ])->response()->getData(true)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CartStoreRequest $request)
    {
        $item = Cart::where('product_id', $request->product_id)->where('customer_id', auth()->id())->first();

        if ($item) {
            $item->increment('amount', 1);
        } else {
            $validated = $request->validated();
            $validated['customer_id'] = auth()->id();

            Cart::create($validated);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Recored has been added successfully.'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        if ($cart->amount > 1) {
            $cart->decrement('amount', 1);
        } else {
            $cart->delete();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Recored has been deleted successfully.'
        ]);
    }

    public function totalCartPrice()
    {
        $items = Cart::where('customer_id', auth()->id())->get();
        $total_price = 0;

        foreach ($items as $item) {
            $price = ($item->product->price - ($item->product->price * ($item->product->discount / 100)));
            $total_price += $price * $item->amount;
        }

        return [
            'items' => $items,
            'total_price' => $total_price
        ];
    }
}
