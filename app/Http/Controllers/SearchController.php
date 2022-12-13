<?php

namespace App\Http\Controllers;

use App\Http\Resources\BasicProductResource;
use App\Models\Product\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'key_word' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ], 422);
        }

        $products = Product::where('approved', 'approved')->where('name', 'LIKE', '%' . $request->key_word . '%')->paginate(12);

        return response()->json(
            BasicProductResource::collection($products)->response()->getData(true)
        );
    }
}
