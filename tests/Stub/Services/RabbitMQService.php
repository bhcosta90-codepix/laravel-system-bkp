<?php

declare(strict_types=1);

namespace Tests\Stub\Services;

use App\Services\Interfaces\AMQPInterface;
use App\Services\Interfaces\RabbitMQInterface;

class RabbitMQService implements AMQPInterface, RabbitMQInterface
{
    public function __construct(protected mixed $data)
    {
        $this->data = json_encode($data);
    }

    public function publish($name, array $value = []): void
    {
        dump($value);
    }

    public function consume(string $queue, array|string $routing, $clojure, $custom = []): void
    {
        $clojure($this->data);
    }

}
