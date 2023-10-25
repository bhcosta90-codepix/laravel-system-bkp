<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

interface RabbitMQInterface
{
    public function consume(string $queue, string|array $routing, $clojure, $custom = []): void;
}
