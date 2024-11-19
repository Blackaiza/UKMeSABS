<?php


    /**
     * Handle an incoming authentication request.
     */    /**
     * Handle an incoming authentication request. hi
     */
    
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/dashboard',[\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard')
    ->middleware(['auth', 'role:admin']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


    /**
     * Handle an incoming authentication request.
     */    /**
     * Handle an incoming authentication request.
     */

require __DIR__.'/auth.php';
