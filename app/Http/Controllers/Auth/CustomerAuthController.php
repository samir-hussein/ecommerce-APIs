<?php

namespace App\Http\Controllers\Auth;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Resources\AddressResource;

class CustomerAuthController extends Controller
{
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email:filter',
            'password' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ], 422);
        }

        $user = Customer::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }

        if ($user->address) {
            $user = collect($user)->merge(collect(new AddressResource($user->address)));
        }

        return response()->json([
            'status' => 'success',
            'data' => $user,
            'access_token' => $user->createToken("API TOKEN")->plainTextToken,
            'token_type' => 'bearer',
            'expires_in' => "30 days"
        ], 200);
    }

    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email:filter|unique:customers,email',
            'phone' => 'required|numeric',
            'password' => 'required|min:8|confirmed'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ], 422);
        }

        Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'The account has been created successfully.'
        ], Response::HTTP_CREATED);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out'
        ], 200);
    }

    public function forgotPassword(Request $request)
    {
        return ForgotPasswordController::requestReset($request, 'customers');
    }

    public function resetPassword(Request $request)
    {
        return ForgotPasswordController::resetPassword($request, 'customers');
    }
}
