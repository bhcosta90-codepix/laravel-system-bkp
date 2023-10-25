<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Interfaces\AMQPInterface;
use App\Services\Interfaces\RabbitMQInterface;
use Bschmitt\Amqp\Facades\Amqp;
use Illuminate\Support\Facades\Log;
use Throwable;

class RabbitMQService implements AMQPInterface, RabbitMQInterface
{
    public function publish($name, array $value = []): void
    {
        Amqp::publish($name, json_encode($value));
    }

    public function consume(string $queue, string|array $routing, $clojure, $custom = []): void
    {
        if (is_string($routing)) {
            $routing = [$routing];
        }

        $routing = [
            'routing' => $routing,
        ];

        do {
            Amqp::consume($queue, function ($message, $resolver) use ($queue, $clojure) {
                try {
                    $clojure($message->body);
                    $resolver->acknowledge($message);
                } catch (Throwable $e) {
                    Log::error("Error consumer {$queue}: " . $e->getMessage() . json_encode($e->getTrace()));
                }
                $resolver->stopWhenProcessed();
            }, $custom + $routing);
            sleep(10);
        } while (true);
    }
}
