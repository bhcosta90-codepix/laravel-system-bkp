<?php

declare(strict_types=1);

namespace System\Domain\Event;

use BRCas\CA\Contracts\Event\EventManagerInterface;

class EventManager implements EventManagerInterface
{
    public function dispatch(array $events): void
    {
        foreach ($events as $value) {
            event($value);
        }
    }
}
