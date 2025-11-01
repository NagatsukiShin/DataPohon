<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TitikController;
// use App\Models\User;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/maps', function () {
    return view('maps');
});

// Route::get('/users', function () {
//     return User::all();
// });


// login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//  register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/{id}/update', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

Route::get('/', [UserController::class, 'index']);


// Route::get('/maps', [TitikController::class, 'index'])->name('map');
// Route::post('/maps', [TitikController::class, 'store']);
// Route::put('/maps/{id}', [TitikController::class, 'update']);

Route::get('/maps', [TitikController::class, 'index'])->name('maps');
Route::post('/maps', [TitikController::class, 'store']);
Route::put('/maps/{id}', [TitikController::class, 'update']);


Route::get('/maps/{id}', [TitikController::class, 'show'])->name('maps.show');

Route::put('/titik/{id}', [TitikController::class, 'update'])->name('titik.update');

// Route::get('/titik/create', [TitikController::class, 'create'])->name('titik.create');
// Route::post('/titik/store', [TitikController::class, 'store'])->name('titik.store');

Route::get('/titik/create', [TitikController::class, 'create'])->name('titik.create');
Route::post('/titik/store', [TitikController::class, 'store'])->name('titik.store');
