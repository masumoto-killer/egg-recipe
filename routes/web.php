<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CycleController;
use App\Http\Controllers\UserController;

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
    return redirect('/index');
})->middleware('auth.user');

Route::get('/welcome', function () {
    if (auth()->check()) {
        return redirect('/index');
    } else {
        return view('welcome');
    }
});

Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/logout', function () {
    auth()->logout(); // Clear the local session or cookies
    return redirect('/welcome');
});

Route::get('/index', [CycleController::class, 'index'])->name('index')->middleware('auth.user');
Route::get('/profile', [UserController::class, 'viewProfile'])->name('profile')->middleware('auth.user');
Route::put('/cycle/{id}', [CycleController::class, 'update'])->name('cycle.update');
Route::post('/cycle/add', [CycleController::class, 'add'])->name('cycle.add');
Route::get('/edit', [CycleController::class, 'edit'])->name('edit')->middleware('auth.user');
Route::delete('/cycle/{id}', [CycleController::class, 'delete'])->name('cycle.delete');

