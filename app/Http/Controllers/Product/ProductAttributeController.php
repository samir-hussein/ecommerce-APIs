<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\Product;
use App\Models\Product\ProductAttribute;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public static function store(array $attributes, string $product_id): array
    {
        $productAttributeIds = [];
        foreach ($attributes as $attr) {
            $validated['attr_name'] = $attr['attr_name'];
            $validated['product_id'] = $product_id;
            $productAttributeIds[] = ProductAttribute::create($validated)->id;
        }

        return $productAttributeIds;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product\ProductAttribute $productAttribute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, ProductAttribute $productAttribute)
    {
        if ($product->id != $productAttribute->product_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not found!'
            ], 404);
        }

        $productAttribute->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'The recored has been deleted successfully.'
        ]);
    }
}
