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

Route::get('downloadmitra/{id}', [PDFController::class, 'mitrapdf'])->name('downloadmitra.pdf');
Route::get('downloadriwayat/{id}', [PDFController::class, 'riwayatpdf'])->name('downloadriwayat.pdf');
Route::get('downloadhistory/{id}', [PDFController::class, 'historypdf'])->name('downloadhistory.pdf');
Route::get('download/{id}', [PDFController::class,'kontrakpdf'])->name('downloadkontrak.pdf');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');