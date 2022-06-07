<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TitleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('titles', [TitleController::class, 'listTitle']);
Route::group(['prefix' => 'categorys'], function () {
    Route::post('update', [CategoryController::class, "updateCategory"]);
    Route::get('list', [CategoryController::class, "listCategory"]);
});
Route::group(['prefix' => 'products'], function () {
    Route::get('list', [ProductController::class, "listProduct"]);
    Route::post('update-product', [ProductController::class,"updateProduct"]);
    Route::post('create-product', [ProductController::class,"createProduct"]);
    Route::delete('delete', [ProductController::class,"deleteProduct"]);
});
