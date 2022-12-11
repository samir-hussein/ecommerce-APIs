<?php

use App\Http\Controllers\Auth\CompanyAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\SellerAuthController;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\BrandCategoryController;
use App\Http\Controllers\BrandSubCategoryController;
use App\Http\Controllers\CompanyAccountController;
use App\Http\Controllers\SubCategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// ----------------------- auth user info -------------------------------
Route::get('/active-user', function (Request $request) {
    return response()->json([
        'data' => $request->user()
    ]);
})->middleware('auth:sanctum');

// ----------------------- company auth routes --------------------------
Route::prefix('company')->controller(CompanyAuthController::class)->group(function () {
    Route::post('/register', 'register')->middleware(['auth:company', 'admin']);
    Route::post('/verify', 'verify');
    Route::post('/login', 'login');
    Route::get('/logout', 'logout')->middleware('auth:company');
    Route::post('/forgot-password', 'forgotPassword');
    Route::post('/reset-password', 'resetPassword');
});

// ---------------------- company account routes --------------------------
Route::apiResource('company/account', CompanyAccountController::class)->middleware('auth:company')->except('store')->missing(function () {
    return response()->json([
        'status' => 'error',
        'message' => 'Not Found!'
    ], 404);
})->parameters([
    'account' => 'user',
]);

Route::put('company/account/{user}/update-role', [CompanyAccountController::class, 'updateRole'])->missing(function () {
    return response()->json([
        'status' => 'error',
        'message' => 'Not Found!'
    ], 404);
})->middleware(['auth:company', 'admin']);

// ----------------------- seller auth routes ---------------------
Route::prefix('seller')->controller(SellerAuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::get('/logout', 'logout')->middleware('auth:seller');
    Route::post('/forgot-password', 'forgotPassword');
    Route::post('/reset-password', 'resetPassword');
});

// ----------------------- customer auth routes ---------------------
Route::prefix('customer')->controller(CustomerAuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::get('/logout', 'logout')->middleware('auth:customer');
    Route::post('/forgot-password', 'forgotPassword');
    Route::post('/reset-password', 'resetPassword');
});

// ------------------------ category routes -------------------------------
Route::apiResource('/category', CategoryController::class)->except('update')->missing(function () {
    return response()->json([
        'status' => 'error',
        'message' => 'Not Found!'
    ], 404);
});

// ------------------------ sub category routes -------------------------------
Route::apiResource('/sub-category', SubCategoryController::class)->except('update')->missing(function () {
    return response()->json([
        'status' => 'error',
        'message' => 'Not Found!'
    ], 404);
});

// ------------------------ brand routes -------------------------------
Route::apiResource('/brand', BrandController::class)->except('update')->missing(function () {
    return response()->json([
        'status' => 'error',
        'message' => 'Not Found!'
    ], 404);
});

Route::apiResource('/brand/category', BrandCategoryController::class)->only(['store', 'destroy'])->missing(function () {
    return response()->json([
        'status' => 'error',
        'message' => 'Not Found!'
    ], 404);
})->middleware('auth:company');

Route::apiResource('/brand/sub-category', BrandSubCategoryController::class)->only(['store', 'destroy'])->missing(function () {
    return response()->json([
        'status' => 'error',
        'message' => 'Not Found!'
    ], 404);
})->middleware('auth:company');

// ------------------------ product routes ------------------------------
Route::apiResource('/product', ProductController::class)->missing(function () {
    return response()->json([
        'status' => 'error',
        'message' => 'Not Found!'
    ]);
});
