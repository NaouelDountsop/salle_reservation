<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReservationController;
// ✅ Cette ligne DOIT être présente en haut de routes/web.php
use App\Http\Controllers\AdminController;
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


/* ── Auth ── */
Route::get('/register',  [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login',     [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login',    [AuthController::class, 'login'])->name('login.post');

Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');

/* ── Page d'accueil ── */
Route::get('/', function () {
    return redirect()->route('rooms.index');
});

/* ── Salles (resource complet) ── */
Route::resource('rooms', RoomController::class);

/* ── Réservations ── */
Route::get('reservations/create/{room}', [ReservationController::class, 'create'])
    ->name('reservations.create');

Route::resource('reservations', ReservationController::class)
    ->except(['create']);

/* ── Administration ── */
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        // Utilisateurs
        Route::post('/users',         [AdminController::class, 'storeUser'])
            ->name('users.store');

        Route::delete('/users/{id}',  [AdminController::class, 'destroyUser'])
            ->name('users.destroy');

        // Salles (modification via admin)
        Route::put('/rooms/{room}',   [AdminController::class, 'updateRoom'])
            ->name('rooms.update');
    });