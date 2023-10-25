<?php

declare(strict_types=1);

namespace System\Domain\Repository;

use App\Models\PixKey;
use CodePix\System\Domain\Entities\Enum\PixKey\KindPixKey;
use CodePix\System\Domain\Entities\Enum\Transaction\StatusTransaction;
use CodePix\System\Domain\Entities\Transaction;
use CodePix\System\Domain\Repository\TransactionRepositoryInterface;
use Costa\Entity\ValueObject\Uuid;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function register(Transaction $transaction): bool
    {
        return (bool)\App\Models\Transaction::create([
            'debit_id' => $transaction->debit,
            'bank' => $transaction->bank,
            'account_from_id' => $transaction->accountFrom,
            'account_to_id' => $transaction->pixKeyTo->account,
            'kind' => $transaction->pixKeyTo->kind,
            'key' => $transaction->pixKeyTo->key,
            'description' => $transaction->description,
            'status' => $transaction->status,
            'value' => $transaction->value,
        ]);
    }

    public function save(Transaction $transaction): bool
    {
        if ($rs = \App\Models\Transaction::find($transaction->id())) {
            return $rs->update([
                'status' => $transaction->status->value,
            ]);
        }

        return false;
    }

    public function find(string $id): ?Transaction
    {
        dd(__FUNCTION__);
    }

    public function findByDebit(string $id): ?Transaction
    {
        if (($transaction = \App\Models\Transaction::where('debit_id', $id)->first()) && ($pix = PixKey::where(
                'key',
                $transaction->key
            )->where('kind', $transaction->kind)->first())) {
            $dataPix = [
                'account' => new Uuid($pix->account_id),
                'kind' => KindPixKey::from($pix->kind),
            ];

            $data = [
                'debit' => new Uuid($transaction->debit_id),
                'accountFrom' => new Uuid($transaction->account_from_id),
                'pixKeyTo' => \CodePix\System\Domain\Entities\PixKey::make($dataPix + $pix->toArray()),
                'status' => StatusTransaction::from($transaction->status),
            ];

            return Transaction::make($data + $transaction->toArray());
        }

        return $transaction;
    }

}
