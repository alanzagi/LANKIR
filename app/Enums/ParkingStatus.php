<?php

namespace App\Enums;

enum ParkingStatus: string
{
  case IN = 'IN';
  case WAIT_PAYMENT = 'WAIT_PAYMENT';
  case PAID = 'PAID';
  case OUT = 'OUT';
}
