<?php

use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('downloadpensiun/{id}', [PDFController::class, 'pensiunpdf'])->name('downloadpensiun.pdf');
Route::get('download/{id}', [PDFController::class,'kontrakpdf'])->name('downloadkontrak.pdf');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
