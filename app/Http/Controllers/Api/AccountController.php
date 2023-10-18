<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Http\Resources\AccountResource;
use CodePix\System\Application\UseCase\AccountUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends Controller
{
    /**
     * @param AccountRequest $accountRequest
     * @param AccountUseCase $accountUseCase
     * @return JsonResponse
     */
    public function store(AccountRequest $accountRequest, AccountUseCase $accountUseCase)
    {
        $response = $accountUseCase->register(
            bank: $accountRequest->bank,
            name: $accountRequest->name,
            agency: $accountRequest->agency,
            number: $accountRequest->number,
        );

        return (new AccountResource($response))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
