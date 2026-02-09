<?php

use App\Http\Controllers\ParkingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ParkingController::class, 'index'])->name('parking.index');

Route::post('/enter', [ParkingController::class, 'enter'])->name('parking.enter');
Route::post('/exit', [ParkingController::class, 'exit'])->name('parking.exit');
