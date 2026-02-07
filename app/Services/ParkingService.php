<?php

namespace App\Services;

use App\Models\ParkingSession;
use App\Models\Ticket;
use App\Models\Tariff;
use App\Enums\ParkingStatus;
use Carbon\Carbon;
use Exception;

class ParkingService
{
  /**
   * Parkir masuk
   */
  public function parkIn(
    Ticket $ticket,
    Tariff $tariff,
    string $vehicleType
  ): ParkingSession {
    // Cegah double park
    if ($ticket->parkingSession) {
      throw new Exception('Ticket already used for parking.');
    }

    return ParkingSession::create([
      'ticket_id'   => $ticket->id,
      'tariff_id'   => $tariff->id,
      'vehicle_type' => $vehicleType,
      'time_in'     => Carbon::now(),
      'status'      => ParkingStatus::IN,
    ]);
  }

  /**
   * Tandai siap bayar
   */
  public function markWaitingPayment(ParkingSession $session): ParkingSession
  {
    if ($session->status !== ParkingStatus::IN) {
      throw new Exception('Invalid parking status transition.');
    }

    $session->update([
      'status' => ParkingStatus::WAIT_PAYMENT,
    ]);

    return $session;
  }

  /**
   * Tandai keluar parkir
   */
  public function markOut(ParkingSession $session): ParkingSession
  {
    if ($session->status !== ParkingStatus::PAID) {
      throw new Exception('Parking not paid.');
    }

    $session->update([
      'status'   => ParkingStatus::OUT,
      'time_out' => Carbon::now(),
    ]);

    return $session;
  }
}
