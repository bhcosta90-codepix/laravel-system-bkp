<?php

declare(strict_types=1);

namespace Tests\Stub\Services;

use App\Services\Interfaces\AMQPInterface;
use App\Services\Interfaces\RabbitMQInterface;

class RabbitMQService implements AMQPInterface, RabbitMQInterface
{
    private string $data;


    public function __construct(protected string $key)
    {
        $data = json_decode(file_get_contents(__DIR__ . '/data.json'), true);
        $this->data = json_encode($data[$key]);
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
