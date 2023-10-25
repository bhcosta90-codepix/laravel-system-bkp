<?php

namespace App\Listeners\Transaction;

use App\Services\Interfaces\AMQPInterface;
use CodePix\System\Domain\Events\Transaction\ConfirmationEvent;

class ConfirmationListener
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
    public function handle(ConfirmationEvent $event): void
    {
        $payload = $event->payload();
        $this->AMQP->publish($payload['bank'] . '.transaction.confirmation', $payload);
    }
}
