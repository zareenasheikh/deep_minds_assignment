<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('login', [App\Http\Controllers\Auth\LoginController::class,'show'])->name('login');
Route::get('oauth/{driver}', [App\Http\Controllers\Auth\LoginController::class,'redirectToProvider'])->name('social.oauth');
Route::get('oauth/{driver}/callback', [App\Http\Controllers\Auth\LoginController::class,'handleProviderCallback'])->name('social.callback');




Route::resource('income', App\Http\Controllers\income_masterController::class);
Route::post('/income-update', [App\Http\Controllers\income_masterController::class, 'income_update'])->name('income-update');
Route::post('income/delete', [App\Http\Controllers\income_masterController::class, 'destroy']);

Route::resource('category', App\Http\Controllers\category_masterController::class);
Route::post('/category-update', [App\Http\Controllers\category_masterController::class, 'category_update'])->name('category-update');
Route::post('category/delete', [App\Http\Controllers\category_masterController::class, 'destroy']);



Route::resource('category', App\Http\Controllers\category_masterController::class);
Route::resource('expense', App\Http\Controllers\expense_masterController::class);


