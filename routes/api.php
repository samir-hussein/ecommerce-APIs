<?php

use App\Http\Controllers\Auth\CompanyAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\SellerAuthController;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\BrandCategoryController;
use App\Http\Controllers\BrandSubCategoryController;
use App\Http\Controllers\CompanyAccountController;
use App\Http\Controllers\Product\ProductAttributeController;
use App\Http\Controllers\Product\ProductAttributeValuesController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\ProductGalleryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SubCategoryController;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Seller;

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
    if ($request->user() instanceof Customer) {
        $user_type = "customer";
    } elseif ($request->user() instanceof Seller) {
        $user_type = "seller";
    } elseif ($request->user() instanceof Company) {
        $user_type = "company";
    }

    return response()->json([
        'user_type' => $user_type,
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
    ], 404);
});

Route::get('/product/{product}/approve', [ProductController::class, 'approve'])->missing(function () {
    return response()->json([
        'status' => 'error',
        'message' => 'Not Found!'
    ], 404);
})->middleware(['auth:company', 'seller_service']);

Route::delete('/product/{product}/gallery/{product_gallery}', [ProductGalleryController::class, 'destroy'])->missing(function () {
    return response()->json([
        'status' => 'error',
        'message' => 'Not Found!'
    ], 404);
})->middleware(['auth:seller', 'EnsureProductOwner']);

Route::delete('/product/{product}/attribute/{product_attribute}', [ProductAttributeController::class, 'destroy'])->missing(function () {
    return response()->json([
        'status' => 'error',
        'message' => 'Not Found!'
    ], 404);
})->middleware(['auth:seller', 'EnsureProductOwner']);

Route::delete('/product/{product}/attribute/{product_attribute}/value/{product_attribute_value}', [ProductAttributeValuesController::class, 'destroy'])->missing(function () {
    return response()->json([
        'status' => 'error',
        'message' => 'Not Found!'
    ], 404);
})->middleware(['auth:seller', 'EnsureProductOwner']);

// ------------------------ product routes ------------------------------
Route::apiResource('/review', ReviewController::class)->missing(function () {
    return response()->json([
        'status' => 'error',
        'message' => 'Not Found!'
    ], 404);
});
