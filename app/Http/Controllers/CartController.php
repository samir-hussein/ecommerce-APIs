<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Resources\CartResource;
use App\Http\Middleware\EnsureCartOwner;
use App\Http\Requests\Cart\CartStoreRequest;
use App\Http\Requests\Cart\CartUpdateRequest;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer')->only(['store', 'index']);

        $this->middleware(['auth:customer', 'EnsureCartOwner'])->only(['destroy', 'update']);
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

        return $this->index();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function update(CartUpdateRequest $request, Cart $cart)
    {
        $cart->update($request->validated());

        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();

        return $this->index();
    }

    public function totalCartPrice()
    {
        $items = Cart::where('customer_id', auth()->id())->latest()->get();
        $total_price = 0;

        foreach ($items as $item) {
            $total_price += $item->product->finalPrice() * $item->amount;
        }

        return [
            'items' => $items,
            'total_price' => $total_price
        ];
    }
}
