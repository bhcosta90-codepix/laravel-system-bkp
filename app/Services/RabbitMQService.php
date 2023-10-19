<?php

declare(strict_types=1);

namespace App\Services;

use Bschmitt\Amqp\Facades\Amqp;
use Throwable;

class RabbitMQService
{
    public function publish($name, array $value = [])
    {
        $appName = config('app.name');
        Amqp::publish($appName . "." . $name, json_encode($value));
    }

    public function consume(string $queue, $clojure, $custom = [])
    {
        do {
            Amqp::consume($queue, function ($message, $resolver) use ($clojure) {
                try {
                    $clojure($message->body);
                } catch (Throwable) {
                    $message->body = "error: " . $message->body;
                }
                $resolver->stopWhenProcessed();
            }, $custom);
            sleep(10);
        } while (true);
    }
}
