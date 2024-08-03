<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\CalendarController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware('auth')->group(function () {
    Route::get('/notes', [NotesController::class, 'index'])->name('notes.index');
    Route::post('/notes/show', [NotesController::class, 'show'])->name('notes.show');
    Route::get('/notes/create', [NotesController::class, 'create'])->name('notes.create');
    Route::post('/notes', [NotesController::class, 'store'])->name('notes.store');
    Route::delete('/notes/{note}', [NotesController::class, 'destroy'])->name('notes.destroy');
    Route::patch('/notes/{note}', [NotesController::class, 'update'])->name('notes.update');
    Route::get('/notes/{note}/edit', [NotesController::class, 'edit'])->name('notes.edit'); // This is important for editing
});

Route::middleware('auth')->group(function () {
    Route::get('/pomodoro', function (){ return view('pomodoro.index');})->name('pomodoro.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::post('/calendar', [CalendarController::class, 'store'])->name('calendar.store');
    Route::get('/calendar/{task}/edit', [CalendarController::class, 'edit'])->name('calendar.edit');
    Route::put('/calendar/{task}', [CalendarController::class, 'update'])->name('calendar.update');
    Route::delete('/calendar/{task}', [CalendarController::class, 'destroy'])->name('calendar.destroy');
});

require __DIR__.'/auth.php';
