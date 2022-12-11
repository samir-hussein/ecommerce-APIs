<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\Product;
use App\Models\Product\ProductAttribute;
use App\Models\Product\ProductAttributeValue;
use Illuminate\Http\Request;

class ProductAttributeValuesController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public static function store(array $attributes, array $productAttributeIds)
    {
        $i = 0;
        $j = 0;
        foreach ($attributes as $attr) {
            foreach ($attr['attr_val'] as $val) {
                $validated[$i]['attr_val'] = $val;
                $validated[$i]['product_attribute_id'] = $productAttributeIds[$j];
                $i++;
            }
            $j++;
        }

        ProductAttributeValue::insert($validated);
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
     * @param  \App\Models\Product\ProductAttributeValue $productAttributeValue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, ProductAttribute $productAttribute, ProductAttributeValue $productAttributeValue)
    {
        if ($productAttribute->product_id != $product->id || $productAttribute->id != $productAttributeValue->product_attribute_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not found!'
            ], 404);
        }

        $productAttributeValue->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'The recored has been deleted successfully.'
        ]);
    }
}
