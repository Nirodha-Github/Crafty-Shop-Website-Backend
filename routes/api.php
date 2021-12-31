<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;

Route::middleware(['cors'])->group(function () {
    Route::post('/register',[AuthController::class,'register']);
    Route::post('/login',[AuthController::class,'login']);
});

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
    Route::get('edit-product/{id}',[ProductController::class,'edit']);
    Route::post('update-product/{id}',[ProductController::class,'update']);
    Route::delete('delete-product/{id}',[ProductController::class,'destroy']);
    
});


Route::middleware(['cors','auth:sanctum'])->group(function () {
    Route::post('logout',[AuthController::class,'logout']);
});




