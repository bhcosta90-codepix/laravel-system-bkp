<?php

declare(strict_types=1);

use App\Console\Commands\Transaction\CompleteCommand;
use App\Models\PixKey;
use App\Models\Transaction;
use CodePix\System\Domain\Entities\Enum\Transaction\StatusTransaction;
use Tests\Stub\Services\RabbitMQService;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    $this->command = new CompleteCommand();

    $this->transaction = Transaction::factory()->create([
        "id" => "018b6346-04c2-73a5-b111-5a70480b0f1b",
        'bank' => 'ea9b5815-1b04-4d34-87e1-16da2787a3bb',
        'debit_id' => '018b6346-04c2-73a5-b111-5a70480b0f1b',
        'kind' => 'id',
        'key' => 'ea5d1de6-66ff-4110-a21e-4d8e15c4859d',
    ]);

    PixKey::factory()->create([
        'bank' => 'ea9b5815-1b04-4d34-87e1-16da2787a3bb',
        'account_id' => '9a7246c5-2840-46f2-b9a2-9b5ab68832a9',
        'kind' => 'id',
        'key' => 'ea5d1de6-66ff-4110-a21e-4d8e15c4859d',
    ]);
});

describe("CompleteCommand Feature Test", function () {
    test("handle", function () {
        $this->command->handle(new RabbitMQService("transaction:complete"));

        assertDatabaseHas('transactions', [
            'debit_id' => '018b6346-04c2-73a5-b111-5a70480b0f1b',
            'status' => StatusTransaction::COMPLETED,
        ]);
    });
});
