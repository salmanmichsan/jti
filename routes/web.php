<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
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
    return redirect('input');
});

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::middleware(['auth:sanctum', 'verified'])->get('/input', function () {
    return view('home');
})->name('input');
Route::middleware(['auth:sanctum', 'verified'])->resource('phone', App\Http\Controllers\NumberphoneController::class);
Route::middleware(['auth:sanctum', 'verified'])->get('/output', [App\Http\Controllers\NumberphoneController::class, 'index'])->name('output');
// Route::middleware(['auth:sanctum', 'verified'])->post('/update/{id}', [App\Http\Controllers\NumberphoneController::class, 'update'])->name('update');
Route::middleware(['auth:sanctum', 'verified'])->get('/edit/{id}', [App\Http\Controllers\NumberphoneController::class, 'edit'])->name('edit');
Route::middleware(['auth:sanctum', 'verified'])->get('/auto', [App\Http\Controllers\NumberphoneController::class, 'auto'])->name('auto');
Route::middleware(['auth:sanctum', 'verified'])->get('/getData', [App\Http\Controllers\NumberphoneController::class, 'output'])->name('getData');


Auth::routes();
Route::resource('phone', App\Http\Controllers\NumberphoneController::class);
// Route::get('/auto', [App\Http\Controllers\NumberphoneController::class, 'auto'])->name('auto');
// Route::get('/output', [App\Http\Controllers\NumberphoneController::class, 'index'])->name('output');
// Route::get('/getData', [App\Http\Controllers\NumberphoneController::class, 'output'])->name('getData');
