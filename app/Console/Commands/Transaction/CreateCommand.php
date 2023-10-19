<?php

namespace App\Console\Commands\Transaction;

use App\Services\RabbitMQService;
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
    public function handle()
    {
        $mqService = new RabbitMQService();
        $mqService->consume("testing", fn($message) => $message == "error" ? throw new \Exception('123') : dump($message));
    }
}
