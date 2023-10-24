<?php

namespace App\Listeners\Transaction;

use App\Services\Interfaces\AMQPInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Tests\Events\Transaction\CreateEvent;

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
        $this->AMQP->publish('transaction.sync', $event->payload());
    }
}
