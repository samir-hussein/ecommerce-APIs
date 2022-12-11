<?php

namespace App\Http\Controllers;

use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:company')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::all();

        if (count($brands) > 0) {
            return response()->json([
                'data' => $brands
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
            'name' => 'required|unique:brands,name'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ], 422);
        }

        Brand::create($validate->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Recored has been added successfully.'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        return response()->json([
            'data' => new BrandResource($brand)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Recored has been deleted successfully.'
        ]);
    }
}
