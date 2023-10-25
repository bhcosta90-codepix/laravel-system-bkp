<?php

namespace App\Console\Commands\Transaction;

use App\Jobs\Transaction\CompleteJob;
use App\Services\Interfaces\RabbitMQInterface;
use Illuminate\Console\Command;

class CompleteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction:complete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Complete a transaction';

    /**
     * Execute the console command.
     */
    public function handle(RabbitMQInterface $rabbitMQService): void
    {
        $rabbitMQService->consume("transaction_complete", "transaction.complete", function ($message) {
            $data = json_decode($message, true);
            dispatch(new CompleteJob($data['id']));
        });
    }
}
