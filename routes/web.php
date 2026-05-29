<?php

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


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/pos', [App\Http\Controllers\PosController::class, 'index'])->name('pos');
Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports');

Route::post('/tickets/registrar', [App\Http\Controllers\TicketController::class, 'store'])->name('tickets.store');

Route::get('/tickets/{id}/print', [App\Http\Controllers\TicketController::class, 'print'])
    ->name('tickets.print');
