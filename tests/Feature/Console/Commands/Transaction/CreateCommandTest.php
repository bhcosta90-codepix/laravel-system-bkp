<?php

declare(strict_types=1);

use App\Console\Commands\Transaction\CreateCommand;
use App\Models\PixKey;
use CodePix\System\Application\UseCase\TransactionUseCase;
use Tests\Stub\Services\RabbitMQService;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    $this->data = '{"bank":"ea9b5815-1b04-4d34-87e1-16da2787a3bb","account_from":{"balance":0,"pix_keys":[],"name":"bruno costa","bank":"ea9b5815-1b04-4d34-87e1-16da2787a3bb","agency":"0ae6f6c8-f9f0-4791-9225-ea4ab7bc5061","number":"7023706","password":"$2y$10$2\/KHTFdLzjb58XnwcDKdHucRGeAqLVofrB1GNeml70uL9Kd78MU92","id":"018b62d8-aec1-730b-831e-301c0ef0954d","created_at":"2023-10-24 18:00:55","updated_at":"2023-10-24 18:00:55"},"value":10,"kind":"id","key":"c98f2ca9-75be-414f-82f2-bb6e215311d5","description":"testing","status":"pending","debit":null,"cancel_description":null,"id":"018b62d8-c783-7130-9008-44350640510e","created_at":"2023-10-24 18:00:55","updated_at":"2023-10-24 18:00:55"}';
    $this->command = new CreateCommand();

    PixKey::factory()->create([
        'bank' => 'ea9b5815-1b04-4d34-87e1-16da2787a3bb',
        'account_id' => '9a7246c5-2840-46f2-b9a2-9b5ab68832a9',
        'kind' => 'id',
        'key' => 'c98f2ca9-75be-414f-82f2-bb6e215311d5',
    ]);
});

describe("CreateCommand Feature Test", function () {
    test("handle", function () {
        $this->command->handle(new RabbitMQService($this->data), app(TransactionUseCase::class));

        assertDatabaseHas('transactions', [
            'bank' => 'ea9b5815-1b04-4d34-87e1-16da2787a3bb',
            'account_from_id' => '018b62d8-aec1-730b-831e-301c0ef0954d',
            'account_to_id' => '9a7246c5-2840-46f2-b9a2-9b5ab68832a9',
            'kind' => 'id',
            'key' => 'c98f2ca9-75be-414f-82f2-bb6e215311d5',
            'description' => 'testing',
            'debit_id' => '018b62d8-c783-7130-9008-44350640510e',
            'status' => "pending",
            'cancel_description' => null,
        ]);
    });
});
