<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\ParkingHistoryController;

Route::get('/', [ParkingController::class, 'index'])->name('parking.index');

Route::post('/enter', [ParkingController::class, 'enter'])->name('parking.enter');
Route::post('/exit', [ParkingController::class, 'exit'])->name('parking.exit');


Route::prefix('parking')->group(function () {
  Route::get('/history', [ParkingHistoryController::class, 'index'])
    ->name('parking.history.index');

  Route::get('/history/{id}', [ParkingHistoryController::class, 'show'])
    ->name('parking.history.show');

  Route::patch('/history/{id}/void', [ParkingHistoryController::class, 'void'])
    ->name('parking.history.void');
});
