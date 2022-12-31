<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageHandler;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\BasicProductResource;
use App\Http\Resources\ProductDetailsResource;
use App\Models\Product\Product;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:seller')->only('store');

        $this->middleware(['auth:seller', 'EnsureProductOwner'])->only(['destroy', 'update']);
    }

    /**
     * approve a product
     *
     * @param  \App\Models\Product\Product $product
     * @return \Illuminate\Http\Response
     */
    public function approve(Product $product)
    {
        if ($product->approved == 'approved') {
            return response()->json([
                'status' => 'success',
                'message' => 'The product already approved.'
            ]);
        }

        $product->update([
            'approved' => 'approved'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'The product has been approved.'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            BasicProductResource::collection(Product::where('approved', 'approved')->latest()->paginate(12))->resource
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        // get validated inputs
        $validated = $request->validated();

        // upload main image
        $main_img = ImageHandler::upload_img($request->file('img'), 'product', 'images');
        $validated['img'] = $main_img['public_id'];
        $validated['secure_url'] = $main_img['secure_url'];

        // store the new product
        $product = Product::create($validated);

        // store product gallery
        if ($request->has('gallery')) {
            ProductGalleryController::store($request->file('gallery'), $product->id);
        }

        // store product attributes and its values
        if ($request->has('attributes')) {
            $productAttributeIds = ProductAttributeController::store($validated['attributes'], $product->id);

            ProductAttributeValuesController::store($validated['attributes'], $productAttributeIds);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'The recored has been added successfully.'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json([
            'data' => new ProductDetailsResource($product)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Product\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        // get validated inputs
        $validated = $request->validated();

        if ($request->has('img')) {
            // delete old main image
            ImageHandler::delete_img($product->img);

            // upload new main image
            $main_img = ImageHandler::upload_img($request->file('img'), 'product', 'images');
            $validated['img'] = $main_img['public_id'];
            $validated['secure_url'] = $main_img['secure_url'];
        }

        if (!$request->has('sub_category_id')) {
            $validated['sub_category_id'] = null;
        }

        if (!$request->has('brand_id')) {
            $validated['brand_id'] = null;
        }

        $validated['approved'] = 'pending';

        // update the product
        $product->update($validated);

        // store product gallery
        if ($request->has('gallery')) {
            ProductGalleryController::store($request->file('gallery'), $product->id);
        }

        // store product attributes and its values
        if ($request->has('attributes')) {
            $productAttributeIds = ProductAttributeController::store($validated['attributes'], $product->id);

            ProductAttributeValuesController::store($validated['attributes'], $productAttributeIds);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'The recored has been updated successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // delete main image
        ImageHandler::delete_img($product->img);

        $productGallery = $product->gallery;
        if ($productGallery) {
            // delete product gallery
            ProductGalleryController::deleteGallery($productGallery);
        }

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'The recored has been deleted successfully.'
        ]);
    }
}
