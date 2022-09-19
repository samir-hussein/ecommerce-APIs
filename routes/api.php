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
    Route::post('/login', 'login');
    Route::post('/verify', 'verify');
    Route::get('/logout', 'logout')->middleware('auth:company');
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

Route::get('test', function () {
    $data = [
        'email' => 'mrcar1858@gmail.com'
    ];
    Mail::send([], $data, function ($message, $data) {
        $message->to($data['email'], 'Tutorials Point')->subject('Laravel Basic Testing Mail');
        $message->from('samirhussein274@gmail.com', 'Samir');
        $message->setBody('Hi, welcome user!');
    });
    return "Basic Email Sent. Check your inbox.";
});
