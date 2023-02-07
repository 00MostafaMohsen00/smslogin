<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login',[AuthController::class,'index'])->name('login')->middleware('guest');
Route::post('/logout',[AuthController::class,'logout'])->name('logout');
Route::post('/login',[AuthController::class,'login'])->name('login_admin');
Route::group(['middleware'=>'auth:admin'],function(){
    Route::get('/dashboard',[AuthController::class,'dashboard'])->name('dashboard');
    Route::resource('user',UserController::class);
    Route::get('user/delete/{id}',[UserController::class,'destroy'])->name('users.destroy');
});
