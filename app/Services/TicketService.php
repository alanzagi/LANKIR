<?php

namespace App\Services;

use App\Models\Ticket;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TicketService
{
  public function issue(): Ticket
  {
    $code = $this->generateCode();

    return Ticket::create([
      'code' => $code,
      'issued_at' => Carbon::now(),
    ]);
  }

  private function generateCode(): string
  {
    $date = now()->format('Ymd');

    $countToday = Ticket::whereDate('issued_at', today())->count();

    $sequence = $countToday + 1;

    return sprintf(
      'PKR-%s-%04d',
      $date,
      $sequence
    );
  }
}
