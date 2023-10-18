<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\PixKeyResource;
use CodePix\System\Application\UseCase\TransactionUseCase;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    public function store(TransactionRequest $transactionRequest, TransactionUseCase $transactionUseCase)
    {
        $response = $transactionUseCase->register(
            account: $transactionRequest->account,
            value: $transactionRequest->value,
            kind: $transactionRequest->kind,
            key: $transactionRequest->key,
            description: $transactionRequest->description,
        );

        return (new PixKeyResource($response))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
