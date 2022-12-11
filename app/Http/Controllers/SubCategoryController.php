<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubCategoryDetailsResource;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:company')->only(['store', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subCategories = SubCategory::all();

        if (count($subCategories) > 0) {
            return response()->json([
                'data' => $subCategories
            ]);
        } else {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|' . Rule::unique('sub_categories', 'name')->where('category_id', $request->category_id)
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ], 422);
        }

        SubCategory::create([
            'name' => $request->name,
            'category_id' => $request->category_id
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Recored has been added successfully.'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubCategory $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategory $subCategory)
    {
        return response()->json([
            'data' => new SubCategoryDetailsResource($subCategory)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubCategory $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategory $subCategory)
    {
        $subCategory->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Recored has been deleted successfully.'
        ]);
    }
}
