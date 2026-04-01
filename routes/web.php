<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AdminController;


/* ── Auth ── */
Route::get('/register',  [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login',     [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login',    [AuthController::class, 'login'])->name('login.post');

Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');


Route::get('/', function () {
    return redirect()->route('rooms.index');
});


Route::resource('rooms', RoomController::class);


Route::get('reservations/create/{room}', [ReservationController::class, 'create'])
    ->name('reservations.create');

Route::resource('reservations', ReservationController::class)
    ->except(['create']);


Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {

     
 Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        
Route::post('/users',        [AdminController::class, 'storeUser'])
            ->name('users.store');

Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])
            ->name('users.destroy');

       
 Route::put('/rooms/{room}',  [AdminController::class, 'updateRoom'])
            ->name('rooms.update');
    });

