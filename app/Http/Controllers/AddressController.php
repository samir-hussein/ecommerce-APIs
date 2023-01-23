<?php

namespace App\Http\Controllers;

use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => new AddressResource(Address::where('customer_id', auth()->id())->first())
        ]);
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
            'country' => 'filled|string',
            'state' => 'filled|string',
            'city' => 'filled|string',
            'address' => 'filled|string',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ], 422);
        }

        $validate = $validate->validated();
        if (!$validate) {
            return response()->json([
                'status' => 'error',
                'message' => 'there is no data to add.'
            ], 422);
        }

        $address = Address::updateOrCreate([
            'customer_id' => auth()->id()
        ], $validate);

        return response()->json([
            'status' => 'success',
            'data' => new AddressResource($address)
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        Address::where('customer_id', auth()->id())->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Recored has been deleted successfully.'
        ]);
    }
}
