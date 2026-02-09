<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ParkingService;
use App\Models\Operator;

class ParkingController extends Controller
{
    public function index()
    {
        // sementara: pakai operator pertama
        $operator = Operator::first();

        return view('parking', compact('operator'));
    }

    public function enter(Request $request, ParkingService $service)
    {
        $request->validate([
            'plate_number' => 'required|string',
            'type'         => 'required|in:motor,mobil',
            'driver_name'  => 'required|string',
        ]);

        try {
            $service->enter(
                $request->plate_number,
                $request->type,
                $request->driver_name
            );

            return back()->with('success', 'Kendaraan berhasil masuk');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function exit(Request $request, ParkingService $service)
    {
        $request->validate([
            'plate_number' => 'required|string',
        ]);

        $operator = Operator::first();

        try {
            $transaction = $service->exitParking(
                $request->plate_number,
                $operator
            );

            return back()->with(
                'success',
                'Kendaraan keluar. Biaya: Rp ' . number_format($transaction->fee)
            );
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
