<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\ServiceController;
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

Route::get('/', function () {
    return view('login');
});
// route::get('file',[AdminController::class,'file']);

Route::get('admin.login', [AdminController::class, 'login'])->name('admin.login');
Route::post('Login_data', [AdminController::class, 'Login_data'])->name('Login_data');
Route::middleware('checkAdmin')->group(function () {
    Route::get('home', [AdminController::class, 'home'])->name('home');
    Route::get('profile', [AdminController::class, 'profile'])->name('profile');
    Route::get('user', [AdminController::class, 'user'])->name('user');
    Route::get('business', [AdminController::class, 'business'])->name('business');
    Route::get('logout',[AdminController::class,'logout'])->name('logout');
    Route::post('changePass',[AdminController::class,'changePass'])->name('changePass');
    Route::get('service_category',[ServiceController::class,'service_category'])->name('service_category');
    Route::post('addservice_category',[ServiceController::class,'addservice_category'])->name('addservice_category');
    Route::get('service/{id}',[ServiceController::class,'service'])->name('service');
    Route::post('addService',[ServiceController::class,'addService'])->name('addservice');

});

Route::get('img',[AdminController::class,'img'])->name('img');

Route::post('check_email',[AdminController::class,'check_email'])->name('check_email');
