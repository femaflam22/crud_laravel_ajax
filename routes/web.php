<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
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

Route::get('/', [StudentController::class, 'view'])->name('home');
Route::get('/student/data', [StudentController::class, 'index'])->name('data');
Route::post('/student/send', [StudentController::class, 'store'])->name('send-data');
Route::get('/student/{id}', [StudentController::class, 'show'])->name('show');
Route::delete('/student/delete/{id}', [StudentController::class, 'destroy'])->name('delete');
