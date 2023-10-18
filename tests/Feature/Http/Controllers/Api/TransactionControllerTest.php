<?php

declare(strict_types=1);

use App\Models\Account;
use App\Models\PixKey;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

beforeEach(function () {
    $this->account01 = Account::factory()->create([
        'bank' => str()->uuid(),
        'agency' => str()->uuid(),
        'number' => '0000000',
    ]);

    $this->account02 = Account::factory()->create([
        'bank' => str()->uuid(),
        'agency' => str()->uuid(),
        'number' => '0000000',
    ]);

    $this->pix01 = PixKey::create([
        'account_id' => $this->account01->id,
        'kind' => 'email',
        'key' => 'test@test.com',
    ]);

    $this->pix02 = PixKey::create([
        'account_id' => $this->account02->id,
        'kind' => 'email',
        'key' => 'test2@test.com',
    ]);
});

describe("TransactionController Feature Test", function () {
    test("store", function(){
        postJson('/api/transaction', [
            'account' => $this->account01->id,
            'value' => 50,
            'kind' => "email",
            'key' => "test2@test.com",
            'description' => 'testing',
        ]);

        assertDatabaseHas('transactions', [
            'account_from_id' => $this->account01->id,
            'account_to_id' => $this->account02->id,
            'value' => 50,
            'kind' => "email",
            'key' => "test2@test.com",
            'description' => 'testing',
        ]);
    });

    describe("exception", function(){
        test("same account", function(){
            postJson('/api/transaction', [
                'account' => $this->account01->id,
                'value' => 50,
                'kind' => "email",
                'key' => "test@test.com",
                'description' => 'testing',
            ])->assertStatus(422)->assertJson([
                'message' => 'account: the source and destination account cannot be the same'
            ]);
        });
    });
});
