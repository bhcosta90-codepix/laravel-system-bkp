<?php

declare(strict_types=1);

use App\Models\Account;
use App\Models\PixKey;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

describe("TransactionController Feature Test", function () {
    beforeEach(function () {
        $this->account = Account::factory()->create([
            'bank' => str()->uuid(),
            'agency' => str()->uuid(),
            'number' => '0000000',
        ]);

        $this->accountPix = Account::factory()->create([
            'bank' => str()->uuid(),
            'agency' => str()->uuid(),
            'number' => '0000000',
        ]);

        $this->pix = PixKey::create([
            'account_id' => $this->accountPix->id,
            'kind' => 'email',
            'key' => 'test@test.com',
        ]);
    });

    test("store", function(){
        postJson('/api/transaction', [
            'account' => $this->account->id,
            'value' => 50,
            'kind' => "email",
            'key' => "test@test.com",
            'description' => 'testing',
        ]);

        assertDatabaseHas('transactions', [
            'account_from_id' => $this->account->id,
            'account_to_id' => $this->accountPix->id,
            'value' => 50,
            'kind' => "email",
            'key' => "test@test.com",
            'description' => 'testing',
        ]);
    });
});
