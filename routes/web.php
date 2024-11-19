<?php
    
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

 // Admin routes with role middleware
 Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/managestaff', [\App\Http\Controllers\AdminController::class, 'managestaff'])->name('admin.managestaff');
    Route::get('/managefacility', [\App\Http\Controllers\AdminController::class, 'managefacility'])->name('admin.managefacility');
    Route::get('/report', [\App\Http\Controllers\AdminController::class, 'report'])->name('admin.report');
        });


      // user routes with role middleware
    Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\UserController::class, 'dashboard'])->name('user.dashboard');
        Route::get('/history', [\App\Http\Controllers\UserController::class, 'history'])->name('user.history');
        Route::get('/booking', [\App\Http\Controllers\UserController::class, 'booking'])->name('user.booking');
      });

     
      Route::get('/dashboard', function () {
        if (Auth::user()->role =='admin') {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user()->role == 'user') {
            return redirect()->route('user.dashboard');
        }
        return abort(403); // Forbidden for undefined roles
    })->middleware(['auth'])->name('dashboard');
    

require __DIR__.'/auth.php';
