<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PixKeyRequest;
use App\Http\Resources\PixKeyResource;
use CodePix\System\Application\UseCase\PixUseCase;
use CodePix\System\Domain\Entities\Enum\PixKey\KindPixKey;
use Symfony\Component\HttpFoundation\Response;

class PixKeyController extends Controller
{
    public function store(string $account, PixKeyRequest $pixKeyRequest, PixUseCase $accountUseCase)
    {
        $response = $accountUseCase->register(
            bank: $pixKeyRequest->bank,
            account: $account,
            kind: $pixKeyRequest->kind,
            key: $pixKeyRequest->key ?: ($pixKeyRequest->kind == KindPixKey::ID->value ? str()->uuid() : null),
        );

        return (new PixKeyResource($response))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
