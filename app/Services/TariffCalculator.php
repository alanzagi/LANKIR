<?php

namespace App\Services;

use App\Models\ParkingSession;
use Carbon\Carbon;
use LogicException;

class TariffCalculator
{
  public function calculate(
    ParkingSession $session,
    ?Carbon $exitTime = null
  ): int {
    $tariff = $session->tariff;

    if (! $tariff || ! $tariff->is_active) {
      throw new LogicException('Inactive or missing tariff.');
    }

    $exitTime ??= Carbon::now();

    $minutes = $session->time_in->diffInMinutes($exitTime);

    // Grace period
    if ($tariff->grace_period_minutes && $minutes <= $tariff->grace_period_minutes) {
      return 0;
    }

    return match ($tariff->pricing_type) {
      'flat' => $tariff->flat_price,

      'flat_hourly' => $this->flatHourly(
        $minutes,
        $tariff->first_hour_price,
        $tariff->next_hour_price
      ),

      default => throw new LogicException('Unsupported pricing type'),
    };
  }

  protected function flatHourly(
    int $minutes,
    int $firstHour,
    int $nextHour
  ): int {
    if ($minutes <= 60) {
      return $firstHour;
    }

    $extraHours = (int) ceil(($minutes - 60) / 60);

    return $firstHour + ($extraHours * $nextHour);
  }
}
