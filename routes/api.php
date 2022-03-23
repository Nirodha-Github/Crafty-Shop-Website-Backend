<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\FrontendController;
use App\Http\Controllers\API\VideoController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\CartController;

Route::middleware(['cors'])->group(function () {
    Route::post('register',[AuthController::class,'register']);
    Route::post('login',[AuthController::class,'login']);
    
});

Route::get('getCategory',[FrontendController::class,'category']);
Route::get('fetchproducts/{slug}',[FrontendController::class,'product']);
Route::get('getUser/{id}',[FrontendController::class,'user']);
Route::post('updateUser/{id}',[FrontendController::class,'userupdate']);
Route::post('store-feedback',[FrontendController::class,'feedback']);
Route::get('view-feedback',[FrontendController::class,'viewfeedback']);
Route::get('viewproductdetail/{category_slug}/{product_slug}',[FrontendController::class,'viewproduct']);
Route::post('add-to-cart',[CartController::class,'addtocart']);

Route::middleware(['cors','auth:sanctum','isAPIAdmin'])->group(function () {
    Route::get('/checkingAuthenticated', function(){
        return response()->json(['message'=>'You are in','status'=>200], 200);
    });

    //category
    Route::post('store-category',[CategoryController::class,'store']);
    Route::get('view-category',[CategoryController::class,'index']);
    Route::get('edit-category/{id}',[CategoryController::class,'edit']);
    Route::put('update-category/{id}',[CategoryController::class,'update']);
    Route::delete('delete-category/{id}',[CategoryController::class,'destroy']);
    Route::get('all-category',[CategoryController::class,'allcategory']);
    
    //user
    Route::get('view-user',[UserController::class,'index']);

    //product
    Route::post('store-product',[ProductController::class,'store']);
    Route::get('view-product',[ProductController::class,'index']);
    Route::get('view-popular-product',[ProductController::class,'popular']);
    Route::get('edit-product/{id}',[ProductController::class,'edit']);
    Route::post('update-product/{id}',[ProductController::class,'update']);
    Route::delete('delete-product/{id}',[ProductController::class,'destroy']);

    //video
    Route::post('store-video',[VideoController::class,'store']);
    Route::get('view-video',[VideoController::class,'index']);
    Route::get('view-recent-video',[VideoController::class,'recent']);
    Route::get('edit-video/{id}',[VideoController::class,'edit']);
    Route::post('update-video/{id}',[VideoController::class,'update']);
    Route::delete('delete-video/{id}',[VideoController::class,'destroy']);
    
    //article
    Route::post('store-article',[ArticleController::class,'store']);
    Route::get('view-article',[ArticleController::class,'index']);
    Route::get('view-single-article/{id}',[ArticleController::class,'single']);
    Route::get('view-recent-article',[ArticleController::class,'recent']);
    Route::get('edit-article/{id}',[ArticleController::class,'edit']);
    Route::post('update-article/{id}',[ArticleController::class,'update']);
    Route::delete('delete-article/{id}',[ArticleController::class,'destroy']);

    //dashboard
    Route::get('view-count',[DashboardController::class,'summary']);
});


Route::middleware(['cors','auth:sanctum'])->group(function () {
    Route::post('logout',[AuthController::class,'logout']);
});




