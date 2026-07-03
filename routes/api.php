<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);


Route::middleware('auth:api')->group(function () {


});