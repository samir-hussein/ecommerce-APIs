<?php

use App\Http\Controllers\Auth\CompanyAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\SellerAuthController;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\CompanyAccountController;
use Illuminate\Support\Facades\Http;

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

// ----------------------- company auth routes --------------------------
Route::prefix('company')->controller(CompanyAuthController::class)->group(function () {
    Route::post('/register', 'register')->middleware('auth:company');
    Route::post('/verify', 'verify');
    Route::post('/login', 'login');
    Route::get('/logout', 'logout')->middleware('auth:company');
    Route::post('/forgot-password', 'forgotPassword');
    Route::post('/reset-password', 'resetPassword');
});

// ---------------------- company account routes --------------------------
Route::prefix('company/account')->middleware(['auth:company', 'isAdmin'])->controller(CompanyAccountController::class)->group(function () {
    Route::put('{user}/update', 'update')->missing(function () {
        return response()->json([
            'status' => 'error',
            'message' => 'Not Found!'
        ]);
    });

    Route::delete('{user}/delete', 'delete')->missing(function () {
        return response()->json([
            'status' => 'error',
            'message' => 'Not Found!'
        ]);
    });
});

// ----------------------- seller auth routes ---------------------
Route::prefix('seller')->controller(SellerAuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::get('/logout', 'logout')->middleware('auth:seller');
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
Route::apiResource('/category', CategoryController::class)->except('update');

// ------------------------ brand routes -------------------------------
Route::apiResource('/brand', BrandController::class)->except('update');

// ------------------------ product routes ------------------------------
Route::apiResource('/product', ProductController::class)->missing(function () {
    return response()->json([
        'status' => 'error',
        'message' => 'Not Found!'
    ]);
});
