<?php

declare(strict_types=1);

use App\Models\Account;

use App\Models\PixKey;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

describe("PixKeyController Feature Test", function () {
    beforeEach(fn() => $this->account = Account::factory()->create([
        'bank' => str()->uuid(),
        'agency' => str()->uuid(),
        'number' => '0000000',
    ]));

    test("store with email", function(){
        postJson('/api/account/' . $this->account->id . '/pix', [
            'kind' => 'email',
            'key' => "bhcosta90@gmail.com",
        ]);

        assertDatabaseHas('pix_keys', [
            'kind' => 'email',
            'key' => "bhcosta90@gmail.com",
        ]);
    });

    test("store with phone", function(){
        postJson('/api/account/' . $this->account->id . '/pix', [
            'kind' => 'phone',
            'key' => "19988745124",
        ]);

        assertDatabaseHas('pix_keys', [
            'kind' => 'phone',
            'key' => "19988745124",
        ]);
    });

    test("store with cpf", function(){
        postJson('/api/account/' . $this->account->id . '/pix', [
            'kind' => 'document',
            'key' => "451.781.949-34",
        ]);

        assertDatabaseHas('pix_keys', [
            'kind' => 'document',
            'key' => "451.781.949-34",
        ]);
    });

    test("store with cnpj", function(){
        postJson('/api/account/' . $this->account->id . '/pix', [
            'kind' => 'document',
            'key' => "40.884.250/0001-56",
        ]);

        assertDatabaseHas('pix_keys', [
            'kind' => 'document',
            'key' => "40.884.250/0001-56",
        ]);
    });

    test("store with random", function(){
        $response = postJson('/api/account/' . $this->account->id . '/pix', [
            'kind' => 'id',
            'key' => "40.884.250/0001-56",
        ]);

        assertDatabaseHas('pix_keys', [
            'kind' => 'id',
            'key' => $response->json('data.key'),
        ]);
    });

    test("registering a new pix that already", function(){
        PixKey::create([
            'account_id' => $this->account->id,
            'kind' => 'email',
            'key' => "bhcosta90@gmail.com",
        ]);

        postJson('/api/account/' . $this->account->id . '/pix', [
            'kind' => 'email',
            'key' => "bhcosta90@gmail.com",
        ])->assertStatus(400);
    });
});
