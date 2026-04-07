<?php

namespace App\Services;

use App\Repositories\ParkingTransactionRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ParkingHistoryService
{
    protected ParkingTransactionRepository $repository;

    public function __construct(ParkingTransactionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getHistory(array $filters)
    {
        return $this->repository->getHistory($filters);
    }

    public function getDetail(int $id)
    {
        $transaction = $this->repository->findById($id);

        if (!$transaction) {
            abort(404, 'Transaksi tidak ditemukan');
        }

        return $transaction;
    }

    public function voidTransaction(int $id, $operator, string $reason): void
    {
        DB::transaction(function () use ($id, $operator, $reason) {

            $transaction = $this->repository->findById($id);

            if (!$transaction) {
                throw ValidationException::withMessages([
                    'transaction' => 'Transaksi tidak ditemukan'
                ]);
            }

            if ($transaction->status !== 'completed') {
                throw ValidationException::withMessages([
                    'transaction' => 'Hanya transaksi selesai yang bisa di-void'
                ]);
            }

            $this->repository->voidTransaction(
                $id,
                $operator->id,
                $reason
            );
        });
    }
}
