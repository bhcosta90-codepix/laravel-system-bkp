<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

interface AMQPInterface
{
    public function publish($name, array $value = []): void;
}
