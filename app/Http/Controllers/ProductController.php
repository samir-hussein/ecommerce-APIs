<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSpecifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:seller', [
            'except' => [
                'index',
                'show'
            ]
        ]);
    }

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
    public function store(Request $request)
    {
        // validate inputs
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'images.*' => 'mimes:jpeg,jpg,png,webp|max:10000',
            'primary_img' => 'required|mimes:jpeg,jpg,png,webp|max:10000',
            'price' => 'required|numeric',
            'description' => 'string',
            'discount' => 'numeric|between:0,100',
            'stock' => 'numeric',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'specifications' => 'array'
        ], [
            'images.*.mimes' => 'Only jpeg,jpg,png and webp images are allowed',
            'images.*.max' => 'Sorry! Maximum allowed size for an image is 10MB',
        ]);

        // check errors validation
        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ], 422);
        }

        // upload the primary image and set seller id
        $request->request->add([
            'primary_image' => ImageHandler::upload_img($request->file('primary_img'), 'product', 'images'),
            'seller_id' => $request->user()->id
        ]);

        // store the product record
        $product = Product::create($request->all());

        // check if the product has specifications to add
        if ($request->has('specifications')) {
            $specifications = [];
            $i = 0;

            foreach ($request->specifications as $key => $val) {
                $specifications[$i] = [
                    'key' => $key,
                    'value' => $val,
                    'product_id' => $product->id
                ];
                $i++;
            }

            ProductSpecifications::insert($specifications);
        }

        // check if the product has images to add
        if ($request->hasFile('images')) {
            $images = [];
            $i = 0;

            foreach ($request->file('images') as $image) {
                $newName = ImageHandler::upload_img($image, 'product', 'images');
                $images[$i] = [
                    'image_name' => $newName,
                    'product_id' => $product->id
                ];
                $i++;
            }

            ProductImage::insert($images);
        }


        return response()->json([
            'status' => 'success',
            'message' => 'The recored has been added successfully.'
        ], 201);
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
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // validate inputs
        $validate = Validator::make($request->all(), [
            'name' => 'filled',
            'images.*' => 'mimes:jpeg,jpg,png,webp|max:10000',
            'primary_img' => 'filled|mimes:jpeg,jpg,png,webp|max:10000',
            'price' => 'filled|numeric',
            'description' => 'string',
            'discount' => 'numeric|between:0,100',
            'stock' => 'numeric',
            'category_id' => 'filled|exists:categories,id',
            'brand_id' => 'filled|exists:brands,id',
            'specifications' => 'array'
        ], [
            'images.*.mimes' => 'Only jpeg,jpg,png and webp images are allowed',
            'images.*.max' => 'Sorry! Maximum allowed size for an image is 10MB',
        ]);

        // check errors validation
        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ], 422);
        }

        if ($request->hasFile('primary_img')) {
            // delete the old image
            ImageHandler::delete_img($product->primary_image, 'images');

            // upload the primary image
            $request->request->add([
                'primary_image' => ImageHandler::upload_img($request->file('primary_img'), 'product', 'images')
            ]);
        }

        // update the product record
        $product->update($request->except('seller_id'));

        // check if the product has specifications to add
        if ($request->has('specifications')) {
            $specifications = [];
            $i = 0;

            foreach ($request->specifications as $key => $val) {
                $specifications[$i] = [
                    'key' => $key,
                    'value' => $val,
                    'product_id' => $product->id
                ];
                $i++;
            }

            ProductSpecifications::insert($specifications);
        }

        // check if the product has images to add
        if ($request->hasFile('images')) {
            $images = [];
            $i = 0;

            foreach ($request->file('images') as $image) {
                $newName = ImageHandler::upload_img($image, 'product', 'images');
                $images[$i] = [
                    'image_name' => $newName,
                    'product_id' => $product->id
                ];
                $i++;
            }

            ProductImage::insert($images);
        }


        return response()->json([
            'status' => 'success',
            'message' => 'The recored has been updated successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
