<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\HigherupController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('user.test');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update-picture', [ProfileController::class, 'updateProfilePicture'])->name('profile.update-picture');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

 /// Admin routes with role middleware /////////////////////////////////////////////////////////////////////////////////////////////////////////////

 Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    //routes for CRUD managenews
    Route::get('/news', [AdminController::class, 'manageNews'])->name('admin.manageNews');
    Route::get('/news/create', [AdminController::class, 'createNews'])->name('admin.createNews');
    Route::post('/news', [AdminController::class, 'storeNews'])->name('admin.storeNews');
    Route::get('/news/{id}/edit', [AdminController::class, 'editNews'])->name('admin.editNews');
    Route::put('/news/{id}', [AdminController::class, 'updateNews'])->name('admin.updateNews');
    Route::delete('/news/{id}', [AdminController::class, 'destroyNews'])->name('admin.destroyNews');

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/managestaff', [AdminController::class, 'managestaff'])->name('admin.managestaff');
    Route::get('/managefacility', [FacilityController::class, 'index'])->name('admin.managefacility'); // Only one managefacility route
    Route::get('/report', [AdminController::class, 'report'])->name('admin.report');

    // Add this route to your web.php file
    Route::get('/gamingpc', [AdminController::class, 'gamingpc'])->name('admin.gamingpc');
    Route::get('/playstation5', [AdminController::class, 'playstation5'])->name('admin.playstation5');
    Route::get('/snooker-a', [AdminController::class, 'snookerA'])->name('admin.snookerA');
    Route::get('/snooker-b', [AdminController::class, 'snookerB'])->name('admin.snookerB');
    Route::get('/racing-simulator', [AdminController::class, 'racingSimulator'])->name('admin.racingSimulator');

    // Seat management routes
    //Route::get('/manage-seats/{facility}', [SeatController::class, 'manageSeats'])->name('seats.manage'); // Route to manage seats for a specific facility
    //Route::post('/seats/{seatId}/update-status', [SeatController::class, 'updateSeatStatus'])->name('seats.updateStatus'); // Update seat status
    //Route::put('/seats/{id}/edit', [AdminController::class, 'racingSimulatorUpdate']);

    //seat setup
    Route::get('/seats/{id}/edit', [AdminController::class, 'editSeats'])->name('admin.seats.edit');
    Route::put('/seats/{id}', [AdminController::class, 'updateSeats'])->name('admin.seats.update');
    Route::delete('/seats/{id}', [AdminController::class, 'destroySeats'])->name('admin.seats.destroy');

    //routes for CRUD managestaff
    Route::get('/staff/create', [AdminController::class, 'createStaff'])->name('admin.staff.create');
    Route::post('/staff', [AdminController::class, 'storeStaff'])->name('admin.staff.store');
    Route::get('/staff/{id}/edit', [AdminController::class, 'editStaff'])->name('admin.staff.edit');
    Route::put('/staff/{id}', [AdminController::class, 'updateStaff'])->name('admin.staff.update');
    Route::delete('/staff/{id}', [AdminController::class, 'destroyStaff'])->name('admin.staff.destroy');



   // Route::post('/higherups/create', [HigherupController::class, 'createHigherup'])->name('admin.higherup.create');
});

/// Staff routes with role middleware /////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::middleware(['auth', 'role:staff'])->prefix('staff')->group(function () {
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('staff.dashboard');
    Route::get('/managestaff', [StaffController::class, 'managestaff'])->name('staff.managestaff');
    Route::get('/managefacility', [StaffController::class, 'managefacility'])->name('staff.managefacility');
    Route::get('/report', [StaffController::class, 'report'])->name('staff.report');

    // Add this route to your web.php file
    Route::get('/gamingpc', [StaffController::class, 'gamingpc'])->name('staff.gamingpc');
    Route::get('/playstation5', [StaffController::class, 'playstation5'])->name('staff.playstation5');
    Route::get('/snooker-a', [StaffController::class, 'snookerA'])->name('staff.snookerA');
    Route::get('/snooker-b', [StaffController::class, 'snookerB'])->name('staff.snookerB');
    Route::get('/racing-simulator', [StaffController::class, 'racingSimulator'])->name('staff.racingSimulator');
});


/// User routes with role middleware /////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/history', [UserController::class, 'history'])->name('user.history');
    Route::get('/booking', [UserController::class, 'booking'])->name('user.booking');

    Route::get('/date-and-time', [UserController::class, 'datetime'])->name('user.date-time');
    Route::get('/gamingpc', [UserController::class, 'gamingpc'])->name('user.gamingpc');
    Route::post('/gamingpc/store', [UserController::class, 'gamingpcStore'])->name('user.gamingpc.store');

    Route::post('/pay', [UserController::class, 'checkout'])->name('user.checkout');
    Route::get('/pay/success', [UserController::class, 'success'])->name('user.checkout.success');
    Route::get('/', [UserController::class, 'cancel'])->name('user.checkout.cancel');
    Route::post('/webhook', [UserController::class, 'webhook'])->name('user.checkout.webhook');


    Route::post('/add-to-cart', [UserController::class, 'StoreCart'])->name('user.add.cart');


    Route::get('/cart-test', function () {
        return view('user.cart');
    });

    // //seat setup
    // Route::post('/seats/{id}', [UserController::class, 'bookSeats'])->name('user.seats.book');
    // Route::get('/seats/{id}/edit', [UserController::class, 'editSeats'])->name('user.seats.edit');
    // Route::put('/seats/{id}', [UserController::class, 'updateSeats'])->name('user.seats.update');
    // Route::delete('/seats/{id}', [UserController::class, 'destroySeats'])->name('user.seats.destroy');
});




Route::get('/dashboard', function () {
    if (Auth::user()->role =='admin') {
        return redirect()->route('admin.dashboard');
    } elseif (Auth::user()->role == 'staff') {
        return redirect()->route('staff.dashboard');
    } elseif (Auth::user()->role == 'user') {
        return redirect()->route('user.dashboard');
    }
    return abort(403); // Forbidden for undefined roles
})->middleware(['auth'])->name('dashboard');


require __DIR__.'/auth.php';

    // Route::get('/gamingpc', [BookingController::class, 'showGamingPC']);
    // Route::get('/date-time', [BookingController::class, 'showDateTime']);
    // Route::get('/seats', [BookingController::class, 'showSeats']);
