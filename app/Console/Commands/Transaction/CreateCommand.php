<?php

namespace App\Console\Commands\Transaction;

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
    public function handle(RabbitMQInterface $rabbitMQService, TransactionUseCase $transactionUseCase): void
    {
        $rabbitMQService->consume("transaction_creating", "transaction.creating", function($message) use($transactionUseCase) {
            $data = json_decode($message, true);
            $transactionUseCase->register(
                bank: $data['bank'],
                account: $data['account_from']['id'],
                value: $data['value'],
                kind: $data['pix_key_to']['kind'],
                key: $data['pix_key_to']['key'],
                description: $data['description'],
            );
        });
    }
}
