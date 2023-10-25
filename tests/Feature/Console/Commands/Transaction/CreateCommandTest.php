<?php

declare(strict_types=1);

use App\Console\Commands\Transaction\CreateCommand;
use App\Models\PixKey;
use Tests\Stub\Services\RabbitMQService;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    $this->command = new CreateCommand();

    PixKey::factory()->create([
        'bank' => 'ea9b5815-1b04-4d34-87e1-16da2787a3bb',
        'account_id' => '9a7246c5-2840-46f2-b9a2-9b5ab68832a9',
        'kind' => 'id',
        'key' => 'ea5d1de6-66ff-4110-a21e-4d8e15c4859d',
    ]);
});

describe("CreateCommand Feature Test", function () {
    test("handle", function () {
        $this->command->handle(new RabbitMQService("transaction:create"));

        assertDatabaseHas('transactions', [
            'bank' => 'ea9b5815-1b04-4d34-87e1-16da2787a3bb',
            'account_from_id' => '018b6333-2612-713c-8b6d-6e7574f2c727',
            'account_to_id' => '9a7246c5-2840-46f2-b9a2-9b5ab68832a9',
            'kind' => 'id',
            'key' => 'ea5d1de6-66ff-4110-a21e-4d8e15c4859d',
            'description' => 'testing',
            'debit_id' => '018b6333-434c-702b-b514-02de403e1fde',
            'status' => "pending",
            'cancel_description' => null,
        ]);
    })->skip();
});
