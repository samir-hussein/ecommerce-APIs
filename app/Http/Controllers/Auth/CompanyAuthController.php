<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\Company;
use App\Mail\VerifyAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Company\CompanyAccountResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class CompanyAuthController extends Controller
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

        $user = Company::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }

        if (!$user->email_verified_at) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please verify your account.'
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'data' => new CompanyAccountResource($user),
            'access_token' => $user->createToken("API TOKEN")->plainTextToken,
            'token_type' => 'bearer',
            'expires_in' => "120 minutes"
        ], 200);
    }

    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email:filter|unique:companies,email',
            'role' => 'required|in:admin,seller service,customer service'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ], 422);
        }

        $details = [
            'token' => Hash::make($request->email | config('app.key')),
            'email' => $request->email
        ];

        try {
            Mail::to($request->email)->send(new VerifyAccount($details));
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong, please try again later.'
            ]);
        }

        Company::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Please check your mail to verify your account and set a password.'
        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out'
        ], 200);
    }

    public function verify(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email:filter',
            'password' => 'required|min:8|confirmed'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ], 422);
        }

        $token = $request->email | config('app.key');

        if (!Hash::check($token, $request->token)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid token'
            ], 422);
        }

        $user = Company::where('email', $request->email)->first();

        if ($user->email_verified_at) {
            return response()->json([
                'status' => 'error',
                'message' => 'The account is already verified'
            ], 422);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'email_verified_at' => now()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'You can login now!'
        ]);
    }

    public function forgotPassword(Request $request)
    {
        return ForgotPasswordController::requestReset($request, 'companies');
    }

    public function resetPassword(Request $request)
    {
        return ForgotPasswordController::resetPassword($request, 'companies');
    }
}
