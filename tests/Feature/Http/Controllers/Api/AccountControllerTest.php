<?php

declare(strict_types=1);

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

describe("AccountController Feature Test", function(){
    test("store", function(){
        $response = postJson('/api/account', [
            'bank' => str()->uuid(),
            'name' => 'testing',
            'agency' => str()->uuid(),
            'number' => '0000000',
        ])->assertStatus(201);

        assertDatabaseHas('accounts', [
            'bank' => $response->json('data.bank'),
            'name' => 'testing',
            'agency' => $response->json('data.agency'),
            'number' => '0000000',
        ]);
    });
});
