<?php

declare(strict_types=1);

namespace System\Domain\Repository;

use CodePix\System\Domain\Entities\Account;
use CodePix\System\Domain\Entities\Enum\PixKey\KindPixKey;
use CodePix\System\Domain\Entities\PixKey;
use CodePix\System\Domain\Repository\PixKeyRepositoryInterface;
use Costa\Entity\ValueObject\Uuid;

class PixKeyRepository implements PixKeyRepositoryInterface
{

    public function register(PixKey $pixKey): bool
    {
        return (bool) \App\Models\PixKey::create([
            'account_id' => $pixKey->account->id(),
            'kind' => $pixKey->kind,
            'key' => $pixKey->key,
        ]);
    }

    public function findKeyByKind(string $kind, string $key): ?PixKey
    {
        if($pix = \App\Models\PixKey::where('key', $key)->where('kind', $kind)->first()){
            return PixKey::make([
                'bank' => $pix->account->bank,
                'kind' => KindPixKey::from($pix->kind),
                'account' => Account::make($pix->account->toArray())
            ] + $pix->toArray());
        }
        return null;
    }

    public function addAccount(Account $account): void
    {
        \App\Models\Account::create($account->toArray());
    }

    public function findAccount(string $id): ?Account
    {
        if ($account = \App\Models\Account::find($id)) {
            return Account::make($account->toArray());
        }

        return null;
    }

    public function findAccountByBankAgencyNumber(string $bank, string $agency, string $number): ?Uuid
    {
        $response = \App\Models\Account::where('bank', $bank)
            ->where('agency', $agency)
            ->where('number', $number)
            ->first();

        return $response
            ? new Uuid($response->id)
            : null;
    }
}
