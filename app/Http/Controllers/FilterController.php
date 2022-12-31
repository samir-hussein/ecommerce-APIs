<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use Illuminate\Http\Request;
use App\Models\Product\Product;

class FilterController extends Controller
{
    public function index(FilterRequest $request)
    {
        return Product::filter(array_keys($request->validated()));
    }
}
