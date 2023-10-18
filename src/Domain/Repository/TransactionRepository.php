<?php

declare(strict_types=1);

namespace System\Domain\Repository;

use CodePix\System\Domain\Entities\Transaction;
use CodePix\System\Domain\Repository\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function register(Transaction $transaction): bool
    {
        return (bool) \App\Models\Transaction::create([
            'account_from_id' => $transaction->accountFrom->id(),
            'account_to_id' => $transaction->pixKeyTo->account->id(),
            'kind' => $transaction->pixKeyTo->kind,
            'key' => $transaction->pixKeyTo->key,
            'description' => $transaction->description,
            'status' => $transaction->status,
            'value' => $transaction->value,
        ]);
    }

    public function save(Transaction $transaction): bool
    {
        dd(__FUNCTION__);
    }

    public function find(string $id): ?Transaction
    {
        dd(__FUNCTION__);
    }

}
