<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Http\Resources\AccountResource;
use CodePix\System\Application\UseCase\AccountUseCase;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * @param AccountRequest $accountRequest
     * @param AccountUseCase $accountUseCase
     * @return AccountResource
     */
    public function store(AccountRequest $accountRequest, AccountUseCase $accountUseCase)
    {
        $response = $accountUseCase->register(
            bank: $accountRequest->bank,
            name: $accountRequest->name,
            agency: $accountRequest->agency,
            number: $accountRequest->number,
        );

        return new AccountResource($response);
    }
}
