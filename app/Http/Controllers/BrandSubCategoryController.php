<?php

namespace App\Http\Controllers;

use App\Models\BrandSubCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class BrandSubCategoryController extends Controller
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
            'brand_id' => 'required|exists:brands,id|' . Rule::unique('brand_sub_categories', 'brand_id')->where('sub_category_id', $request->sub_category_id) . '|' . Rule::exists('brand_categories', 'brand_id')->where('category_id', $request->category_id),
            'category_id' => 'required|' . Rule::exists('sub_categories', 'category_id')->where('id', $request->sub_category_id),
            'sub_category_id' => 'required|exists:sub_categories,id'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ], 422);
        }

        BrandSubCategory::create($validate->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Recored has been added successfully.'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BrandSubCategory $brandSubCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(BrandSubCategory $brandSubCategory)
    {
        $brandSubCategory->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Recored has been deleted successfully.'
        ]);
    }
}
