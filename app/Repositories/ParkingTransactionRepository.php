<?php

namespace App\Repositories;

use App\Models\ParkingTransaction;

class ParkingTransactionRepository
{
    public function getHistory(array $filters)
    {
        $query = ParkingTransaction::query()
            ->with(['operator', 'vehicleType'])
            ->orderByDesc('check_in_at');

        if (!empty($filters['plate'])) {
            $query->where('plate_number', 'like', '%' . $filters['plate'] . '%');
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('check_in_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('check_in_at', '<=', $filters['date_to']);
        }

        return $query->paginate(15);
    }

    public function findById(int $id)
    {
        return ParkingTransaction::with(['operator', 'vehicleType'])
            ->find($id);
    }

    public function voidTransaction(int $id, int $operatorId, string $reason): void
    {
        ParkingTransaction::where('id', $id)->update([
            'status'       => 'void',
            'void_reason'  => $reason,
            'voided_by'    => $operatorId,
            'voided_at'    => now(),
        ]);
    }
}
