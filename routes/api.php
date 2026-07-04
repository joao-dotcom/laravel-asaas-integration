<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoicesController;
use Illuminate\Support\Facades\Route;

Route::get('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);


Route::middleware('auth:api')->group(function () {

    Route::post('/storeInvoice',[InvoicesController::class,'storeInvoice']);
    Route::get('/clientInvoices',[ClientController::class,'clientInvoices']);

});