<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OngkirController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('/ongkir')->name('ongkir.')->group(function () {
    Route::get('/city', [OngkirController::class, 'city'])->name('city');
    Route::get('/province', [OngkirController::class, 'province'])->name('province');
    Route::post('/cost', [OngkirController::class, 'cost'])->name('cost');
});

Route::prefix('/auth')->name('auth.')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('/product')->name('product.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/show', [ProductController::class, 'show'])->name('show');
        Route::get('/collections', [ProductController::class, 'collections'])->name('collections');
        Route::post('/add-collection', [ProductController::class, 'addCollection'])->name('add-collection');
    });
    Route::prefix('/product-category')->name('product-category.')->group(function () {
        Route::get('/', [ProductCategoryController::class, 'index'])->name('index');
    });
    Route::prefix('/cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/store', [CartController::class, 'store'])->name('store');
        Route::post('/delete', [CartController::class, 'delete'])->name('delete');
    });
    Route::prefix('/auth')->name('auth.')->group(function () {
        Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change-password');
    });
    Route::prefix('/profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::post('/store', [ProfileController::class, 'store'])->name('store');
        Route::get('/address', [ProfileController::class, 'address'])->name('address');
        Route::get('/address', [ProfileController::class, 'address'])->name('address');
        Route::post('/create-address', [ProfileController::class, 'createAddress'])->name('create-address');
        Route::post('/update-address', [ProfileController::class, 'updateAddress'])->name('update-address');
        Route::post('/delete-address', [ProfileController::class, 'deleteAddress'])->name('delete-address');
        Route::post('/set-address', [ProfileController::class, 'setAddress'])->name('set-address');
    });
});
