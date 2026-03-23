<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReservationController;
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

// 


// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('rooms', RoomController::class);



//  IMPORTANT : on surcharge uniquement la route create avec paramètre
Route::get('reservations/create/{room}', [ReservationController::class, 'create'])
    ->name('reservations.create');

// Autres routes REST
Route::resource('reservations', ReservationController::class)
    ->except(['create']);


    Route::get('/', function () {
        auth()->logout(); // force logout
        return view('welcome');
    });