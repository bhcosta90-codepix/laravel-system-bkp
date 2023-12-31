<?php

namespace App\Listeners\Transaction;

use App\Services\Interfaces\AMQPInterface;
use CodePix\System\Domain\Events\Transaction\CreateEvent;

class CreateListener
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
    public function handle(CreateEvent $event): void
    {
        $payload = $event->payload();
        $this->AMQP->publish($payload['bank'] . '.transaction.creating', $payload);
    }
}
