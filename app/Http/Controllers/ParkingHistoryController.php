<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ParkingHistoryService;

class ParkingHistoryController extends Controller
{
    protected ParkingHistoryService $service;

    public function __construct(ParkingHistoryService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $filters = $request->only([
            'date_from',
            'date_to',
            'plate',
            'status',
            'operator_id'
        ]);

        $histories = $this->service->getHistory($filters);

        return view('parking.history.index', compact('histories', 'filters'));
    }

    public function show(int $id)
    {
        $transaction = $this->service->getDetail($id);

        return view('parking.history.show', compact('transaction'));
    }

    public function void(Request $request, int $id)
    {
        $request->validate([
            'reason' => 'required|string|min:5',
        ]);

        $this->service->voidTransaction(
            $id,
            auth()->user(),
            $request->reason
        );

        return redirect()
            ->route('parking.history.index')
            ->with('success', 'Transaksi berhasil di-void');
    }
}
