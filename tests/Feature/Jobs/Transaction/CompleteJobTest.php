<?php

declare(strict_types=1);

use App\Jobs\Transaction\CompleteJob;
use App\Models\PixKey;
use App\Models\Transaction;
use CodePix\System\Application\UseCase\TransactionUseCase;
use CodePix\System\Domain\Entities\Enum\Transaction\StatusTransaction;
use Illuminate\Support\Facades\Event;
use Tests\Stub\Services\Data;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    Event::fake();

    $this->transaction = Transaction::factory()->create([
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

describe("CompleteJob Unit Test", function(){
    test("handle", function(){
        $job = new CompleteJob(Data::get('transaction:confirmation')["id"]);
        $job->handle(app(TransactionUseCase::class));

        assertDatabaseHas('transactions', [
            'debit_id' => '018b6346-04c2-73a5-b111-5a70480b0f1b',
            'status' => StatusTransaction::COMPLETED,
        ]);
    });
});
