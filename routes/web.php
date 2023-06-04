<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CodeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();

Route::get('/generate-code', [CodeController::class, 'generateCode']);

Route::get('/', [CodeController::class,'View'])->middleware('auth');

Route::get('/dashboeard', [CodeController::class,'dashboard']);

Route::get('/verficationcode', [CodeController::class,'Verificationcode'])->name('check-code');



