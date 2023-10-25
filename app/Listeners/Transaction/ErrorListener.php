<?php

namespace App\Listeners\Transaction;

use App\Services\Interfaces\AMQPInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ErrorListener
{
    /**
     * Create the event listener.
     */
    public function __construct(protected AMQPInterface $AMQP)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $payload = $event->payload();
        $this->AMQP->publish($payload['bank'] . '.transaction.error', $payload);
    }
}
