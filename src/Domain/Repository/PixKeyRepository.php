<?php

declare(strict_types=1);

namespace System\Domain\Repository;

use CodePix\System\Domain\Entities\Account;
use CodePix\System\Domain\Entities\PixKey;
use CodePix\System\Domain\Repository\PixKeyRepositoryInterface;

class PixKeyRepository implements PixKeyRepositoryInterface {

    public function register(PixKey $pixKey): bool
    {
        throw new Exception();
    }

    public function findKeyByKind(string $key, string $kind): ?PixKey
    {
        throw new Exception();
    }

    public function addAccount(Account $account): void
    {
        \App\Models\Account::create($account->toArray());
    }

    public function findAccount(string $id): ?Account
    {
        // TODO: Implement findAccount() method.
    }
}
