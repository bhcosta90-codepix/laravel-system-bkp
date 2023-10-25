<?php

namespace App\Jobs\Transaction;

use CodePix\System\Application\UseCase\TransactionUseCase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ConfirmationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string $id)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(TransactionUseCase $transactionUseCase): void
    {
        $transactionUseCase->confirm($this->id);
    }
}
