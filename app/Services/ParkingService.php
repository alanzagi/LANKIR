<?php

namespace App\Services;

use App\Models\Vehicle;
use App\Models\Operator;
use App\Models\Payment;
use App\Models\ParkingTransaction;
use Illuminate\Support\Facades\DB;

class ParkingService
{
  /**
   * Kendaraan masuk parkir
   */
  public function enter(
    string $plateNumber,
    string $type,
    string $driverName
  ): ParkingTransaction {
    return DB::transaction(function () use ($plateNumber, $type, $driverName) {

      $vehicle = Vehicle::firstOrCreate(
        ['plate_number' => $plateNumber],
        [
          'type' => $type,
          'driver_name' => $driverName,
        ]
      );

      if ($vehicle->activeParking()->exists()) {
        throw new \Exception('Kendaraan masih sedang parkir');
      }

      return ParkingTransaction::create([
        'vehicle_id' => $vehicle->id,
        'entered_at' => now(),
        'status'     => ParkingTransaction::STATUS_PARKED,
      ]);
    });
  }

  /**
   * Kendaraan keluar parkir
   */
  public function exitParking(
    string $plateNumber,
    Operator $operator
  ): ParkingTransaction {
    return DB::transaction(function () use ($plateNumber, $operator) {

      $vehicle = Vehicle::where('plate_number', $plateNumber)->first();

      if (!$vehicle) {
        throw new \Exception('Kendaraan tidak ditemukan');
      }

      $transaction = $vehicle->activeParking()->first();

      if (!$transaction) {
        throw new \Exception('Kendaraan tidak sedang parkir');
      }

      $fee = $this->calculateFee($transaction);

      $transaction->update([
        'exited_at' => now(),
        'fee'       => $fee,
        'status'    => ParkingTransaction::STATUS_COMPLETED,
      ]);

      Payment::create([
        'parking_transaction_id' => $transaction->id,
        'operator_id'             => $operator->id,
        'amount'                  => $fee,
        'paid_at'                 => now(),
      ]);

      $operator->increment('balance', $fee);

      return $transaction;
    });
  }

  /**
   * Hitung tarif parkir
   */
  protected function calculateFee(ParkingTransaction $transaction): int
  {
    $minutes = $transaction->durationInMinutes();
    $hours   = max(1, ceil($minutes / 60));

    $rate = match ($transaction->vehicle->type) {
      'motor' => 2000,
      'mobil' => 5000,
      default => throw new \Exception('Jenis kendaraan tidak valid'),
    };

    return $hours * $rate;
  }
}
