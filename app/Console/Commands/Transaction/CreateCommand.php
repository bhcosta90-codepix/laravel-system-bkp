<?php

namespace App\Console\Commands\Transaction;

use App\Jobs\Transaction\CreateJob;
use App\Services\Interfaces\RabbitMQInterface;
use CodePix\System\Application\UseCase\TransactionUseCase;
use Illuminate\Console\Command;

class CreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creating a new transaction';

    /**
     * Execute the console command.
     */
    public function handle(RabbitMQInterface $rabbitMQService): void
    {
        $rabbitMQService->consume("transaction_creating", "transaction.creating", function($message) {
            $data = json_decode($message, true);
            dispatch(new CreateJob($data));
        });
    }
}
