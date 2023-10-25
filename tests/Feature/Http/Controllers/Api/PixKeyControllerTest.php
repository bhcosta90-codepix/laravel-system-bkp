<?php

declare(strict_types=1);

use App\Models\PixKey;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

describe("PixKeyController Feature Test", function () {
    beforeEach(fn() => $this->account = str()->uuid());

    test("store with email", function () {
        postJson('/api/account/' . $this->account . '/pix', [
            'bank' => str()->uuid(),
            'kind' => 'email',
            'key' => "bhcosta90@gmail.com",
        ])->assertJsonStructure([
            'data' => [
                'bank',
                'kind',
                'account',
                'key',
                'status',
                'id',
                'created_at',
                'updated_at',
            ],
        ]);

        assertDatabaseHas('pix_keys', [
            'kind' => 'email',
            'key' => "bhcosta90@gmail.com",
        ]);
    });

    test("store with phone", function () {
        postJson('/api/account/' . $this->account . '/pix', [
            'bank' => str()->uuid(),
            'kind' => 'phone',
            'key' => "19988745124",
        ]);

        assertDatabaseHas('pix_keys', [
            'kind' => 'phone',
            'key' => "19988745124",
        ]);
    });

    test("store with cpf", function () {
        postJson('/api/account/' . $this->account . '/pix', [
            'bank' => $bank = str()->uuid(),
            'kind' => 'document',
            'key' => "451.781.949-34",
        ]);

        assertDatabaseHas('pix_keys', [
            'bank' => $bank,
            'kind' => 'document',
            'key' => "451.781.949-34",
        ]);
    });

    test("store with cnpj", function () {
        postJson('/api/account/' . $this->account . '/pix', [
            'bank' => $bank = str()->uuid(),
            'kind' => 'document',
            'key' => "40.884.250/0001-56",
        ]);

        assertDatabaseHas('pix_keys', [
            'bank' => $bank,
            'kind' => 'document',
            'key' => "40.884.250/0001-56",
        ]);
    });

    test("store with random", function () {
        $response = postJson('/api/account/' . $this->account . '/pix', [
            'bank' => $bank = str()->uuid(),
            'kind' => 'id',
            'key' => "40.884.250/0001-56",
        ]);

        assertDatabaseHas('pix_keys', [
            'bank' => $bank,
            'kind' => 'id',
            'key' => $response->json('data.key'),
        ]);
    });

    test("registering a new pix that already", function () {
        PixKey::create([
            'bank' => $bank = str()->uuid(),
            'account_id' => $this->account,
            'kind' => 'email',
            'key' => "bhcosta90@gmail.com",
        ]);

        postJson('/api/account/' . $this->account . '/pix', [
            'bank' => $bank,
            'kind' => 'email',
            'key' => "bhcosta90@gmail.com",
        ])->assertStatus(422);
    });
});
