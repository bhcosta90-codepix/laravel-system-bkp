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
        return (bool)\App\Models\PixKey::create([
            'bank' => $pixKey->bank,
            'account_id' => $pixKey->account,
            'kind' => $pixKey->kind,
            'key' => $pixKey->key,
        ]);
    }

    public function findKeyByKind(string $kind, string $key): ?PixKey
    {
        if ($pix = \App\Models\PixKey::where('key', $key)->where('kind', $kind)->first()) {
            return PixKey::make(
                [
                    'bank' => $pix->bank,
                    'kind' => KindPixKey::from($pix->kind),
                    'account' => $pix->account_id,
                ] + $pix->toArray()
            );
        }
        return null;
    }
}
