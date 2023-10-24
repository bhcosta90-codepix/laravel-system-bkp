<?php

declare(strict_types=1);

use App\Console\Commands\Transaction\CreateCommand;
use App\Models\PixKey;
use CodePix\System\Application\UseCase\TransactionUseCase;
use Tests\Stub\Services\RabbitMQService;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    $this->data = '{"bank":"ea9b5815-1b04-4d34-87e1-16da2787a3bb","account_from":{"balance":0,"pix_keys":[],"name":"Caio Flores","bank":"ea9b5815-1b04-4d34-87e1-16da2787a3bb","agency":"87a85b1e-958b-4bc9-a933-79018dd3e4f0","number":"81039008","password":"$2y$10$rjNzVzAokxMJiCzV0HkUluWZRbp.ZE4BrIJ3TtxwX3Jq1QJ7W0sAS","id":"9a7246c5-2747-46c2-9b44-6ba56b83be95","created_at":"2023-10-24 14:00:42","updated_at":"2023-10-24 14:00:42"},"value":10,"pix_key_to":{"reference":"66daf44e-b74c-4b0e-9505-81a2886d0be2","bank":"ea9b5815-1b04-4d34-87e1-16da2787a3bb","kind":"id","account":{"balance":0,"pix_keys":[],"name":"Ant\u00f4nio Renato Azevedo","bank":"ea9b5815-1b04-4d34-87e1-16da2787a3bb","agency":"5c69941c-43fa-4e36-ad15-40bffa665db0","number":"46976441","password":"$2y$10$rjNzVzAokxMJiCzV0HkUluWZRbp.ZE4BrIJ3TtxwX3Jq1QJ7W0sAS","id":"9a7246c5-2840-46f2-b9a2-9b5ab68832a9","created_at":"2023-10-24 14:00:42","updated_at":"2023-10-24 14:00:42"},"key":"6860b687-a250-4154-8a55-3d603af2e916","status":true,"id":"9a7246c5-28bc-41d6-852b-6779c0f5822e","created_at":"2023-10-24 14:00:42","updated_at":"2023-10-24 14:00:42"},"description":"testing","status":"pending","cancel_description":null,"id":"018b61fc-da0e-703c-8a55-cfff303059b1","created_at":"2023-10-24 14:00:42","updated_at":"2023-10-24 14:00:42"}';
    $this->command = new CreateCommand();

    PixKey::factory()->create([
        'bank' => 'ea9b5815-1b04-4d34-87e1-16da2787a3bb',
        'account_id' => '9a7246c5-2840-46f2-b9a2-9b5ab68832a9',
        'kind' => 'id',
        'key' => '6860b687-a250-4154-8a55-3d603af2e916',
    ]);
});

describe("CreateCommand Feature Test", function () {
    test("handle", function () {
        $this->command->handle(new RabbitMQService($this->data), app(TransactionUseCase::class));

        assertDatabaseHas('transactions', [
            'bank' => 'ea9b5815-1b04-4d34-87e1-16da2787a3bb',
            'account_from_id' => '9a7246c5-2747-46c2-9b44-6ba56b83be95',
            'account_to_id' => '9a7246c5-2840-46f2-b9a2-9b5ab68832a9',
            'kind' => 'id',
            'key' => '6860b687-a250-4154-8a55-3d603af2e916',
            'description' => 'testing',
            'status' => "pending",
            'cancel_description' => null,
        ]);
    });
});
