<?php

namespace App\Http\Controllers;

use App\Models\BrandCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BrandCategoryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'brand_id' => 'required|exists:brands,id|' . Rule::unique('brand_categories', 'brand_id')->where('category_id', $request->category_id),
            'category_id' => 'required|exists:categories,id'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ], 422);
        }

        BrandCategory::create($validate->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Recored has been added successfully.'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BrandCategory $brandCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(BrandCategory $brandCategory)
    {
        $brandCategory->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Recored has been deleted successfully.'
        ]);
    }
}
