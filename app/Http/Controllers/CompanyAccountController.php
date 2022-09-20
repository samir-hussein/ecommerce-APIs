<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CompanyAccountController extends Controller
{
    public function update(Request $request, Company $user)
    {
        if ($request->has('role')) {
            return response()->json([
                'status' => 'error',
                'message' => "You don't have permission."
            ], 401);
        }

        $validate = Validator::make($request->all(), [
            'name' => 'filled',
            'img' => 'mimes:jpeg,jpg,png,webp|max:10000',
            'password' => 'filled|confirmed',
            'old_password' => 'required_with:password|different:password',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ], 422);
        }

        if ($request->has('img')) {
            if ($user->public_id) {
                ImageHandler::delete_img($user->public_id);
            }

            // upload the profile image
            $profile = ImageHandler::upload_img($request->file('img'), 'profile', 'images');
            $request->request->add([
                'public_id' => $profile['public_id'],
                'image' => $profile['secure_url'],
            ]);
        }

        if ($request->has('password')) {
            if (!Hash::check($request->old_password, $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Old password is wrong.'
                ], 422);
            }

            $request->request->add([
                'password' => Hash::make($request->password)
            ]);
        }

        $user->update($request->except('role'));

        return response()->json([
            'status' => 'success',
            'message' => 'The information has been updated successfully.'
        ]);
    }

    /**
     * Undocumented function
     *
     * @param \App\Models\Company $user
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, Company $user)
    {
        if ($user->public_id) {
            ImageHandler::delete_img($user->public_id);
        }

        $user->tokens()->delete();

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'The account has been deleted successfully.'
        ]);
    }

    public function updateRole(Request $request, Company $user)
    {
        $validate = Validator::make($request->all(), [
            'role' => 'required|in:admin,seller service,customer service',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ], 422);
        }

        $user->update($request->only('role'));

        return response()->json([
            'status' => 'success',
            'message' => 'The role has been updated successfully.'
        ]);
    }
}
