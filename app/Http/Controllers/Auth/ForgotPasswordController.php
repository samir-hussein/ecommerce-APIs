<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Mail\ForgotPassword;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\password_resets;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    public static function requestReset(Request $request, $table)
    {
        $validate = Validator::make($request->all(), [
            'email' => "required|email:filter|exists:$table,email"
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ], 422);
        }

        $expire = strtotime(date('Y-m-d H:i:s', strtotime("+20 minutes")));

        $token = Hash::make("$request->email|$table");

        $details = [
            'token' => $token,
            'email' => $request->email,
        ];

        try {
            Mail::to($request->email)->send(new ForgotPassword($details));
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong, please try again later.'
            ], 502);
        }

        password_resets::create([
            'email' => $request->email,
            'token' => $token,
            'expire' => $expire
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'We have e-mailed your password reset link!',
            'expire_in' => '20 minutes'
        ]);
    }

    public static function resetPassword(Request $request, $table)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email:filter',
            'token' => 'required',
            'password' => 'required|confirmed|min:8'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ], 422);
        }

        $token = "$request->email|$table";

        if (!Hash::check($token, $request->token)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid token.'
            ], 498);
        }

        $data = password_resets::where('email', $request->email)->where('token', $request->token)->first();

        if (!$data) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid token.'
            ], 498);
        }

        if ($data->expire < strtotime(date('Y-m-d H:i:s'))) {
            return response()->json([
                'status' => 'error',
                'message' => 'the token is expired.'
            ], 498);
        }

        password_resets::where('email', $request->email)->where('token', $request->token)->delete();

        DB::table($table)->where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Password has changed successfully. Login now!'
        ]);
    }
}
