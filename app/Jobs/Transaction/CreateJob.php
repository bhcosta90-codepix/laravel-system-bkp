<?php

namespace App\Jobs\Transaction;

use CodePix\System\Application\UseCase\TransactionUseCase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected array $data)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(TransactionUseCase $transactionUseCase): void
    {
        $transactionUseCase->register(
            debit: $this->data['id'],
            bank: $this->data['bank'],
            account: $this->data['account_from']['id'],
            value: $this->data['value'],
            kind: $this->data['kind'],
            key: $this->data['key'],
            description: $this->data['description'],
        );
    }
}
