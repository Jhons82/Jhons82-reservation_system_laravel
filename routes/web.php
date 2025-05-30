<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;

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


// Calendar for administrator
Route::get('reservations/calendar', function() {
    return view('reservations.calendar');
})->name('reservations.calendar');
Route::get('/administrator/fullcalendar', [ReservationController::class, 'getAllReservations'])->name('reservations.data');

// Calendar for adviser
Route::get('adviser/calendar', function() {
    return view('adviser.calendar');
})->name('adviser.calendar');
Route::get('/adviser/fullcalendar', [ReservationController::class, 'getAllReservationsAdviser'])->name('reservationsAdviser.data');

//Calendar for clients
Route::get('client/calendar', function() {
    return view('client.calendar');
})->name('client.calendar');
Route::get('/client/fullcalendar', [ReservationController::class, 'getAllReservationsClient'])->name('reservationsClient.data');

//index for clients
Route::get('/client', [ReservationController::class, 'indexClient'])->name('client.index');

//Create for clients
Route::get('/client/create', [ReservationController::class, 'createClient'])->name('client.create');

Route::post('/paypal',[ReservationController::class,'completePayment']);

Route::resource('usuarios', UserController::class);

Route::resource('reservations', ReservationController::class);

Route::post('reservations.cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');



require __DIR__.'/auth.php';
