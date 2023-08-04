<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;

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

Route::get('/welcome', function () {
    $user = auth();
    if ($user) {
        return redirect('/index');
    } else {
        return view('welcome');
    }
});

Route::get('/index', function () {
    $user = auth();
    if ($user) {
        return view('index');
    } else {
        return redirect('/welcome');
    }
});

Route::get('/', function () {
    $user = auth();
    if ($user) {
        return redirect('/index');
    } else {
        return redirect('/welcome');
    }
});

Route::get('/logout', [LoginController::class, 'logout'] () );

Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
