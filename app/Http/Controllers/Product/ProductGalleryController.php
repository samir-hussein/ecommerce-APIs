<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageHandler;
use App\Models\Product\Product;
use App\Models\Product\ProductGallery;

class ProductGalleryController extends Controller
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
    public static function store(array $images, string $product_id)
    {
        $i = 0;
        foreach ($images as $image) {
            // upload images
            $main_img = ImageHandler::upload_img($image, 'product_gallery', 'images');
            $validated[$i]['img'] = $main_img['public_id'];
            $validated[$i]['secure_url'] = $main_img['secure_url'];
            $validated[$i]['product_id'] = $product_id;
            $i++;
        }

        ProductGallery::insert($validated);
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
     * @param  \App\Models\Product\ProductGallery $product_gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, ProductGallery $product_gallery)
    {
        if ($product_gallery->product_id != $product->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not Found!'
            ], 404);
        }

        ImageHandler::delete_img($product_gallery->img);
        $product_gallery->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'The recored has been deleted successfully.'
        ]);
    }

    public static function deleteGallery($productGallery)
    {
        foreach ($productGallery as $img) {
            ImageHandler::delete_img($img->img);
        }
    }
}
