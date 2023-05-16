<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TabellaController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\KedvencekController;


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
//Route::get('/index', [GameController::class, 'index']);
Route::resource('games', GameController::class);
Route::resource('teams', TeamController::class);
Route::resource('events', EventController::class);
Route::resource('tabella', TabellaController::class);
Route::resource('players', PlayerController::class);
Route::resource('kedvencek', KedvencekController::class);

//welcome page
Route::get('/welcome', function () {
    return view('welcome');
});


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
