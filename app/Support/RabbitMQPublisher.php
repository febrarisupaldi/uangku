<?php

namespace App\Support;

use Enqueue\AmqpExt\AmqpConnectionFactory;
use Interop\Amqp\AmqpContext;
use Interop\Amqp\AmqpQueue;
use Interop\Queue\Context;

class RabbitMQPublisher
{
    protected AmqpContext $context;

    public function __construct()
    {
        $factory = new AmqpConnectionFactory(
            [
                'dsn' => env('RABBITMQ_DSN', 'amqp://paldi:paldi@127.0.0.1:5672/'),
            ]
        );
        $this->context = $factory->createContext();
    }

    public function getContext(): AmqpContext
    {
        return $this->context;
    }

    public function send(string $queueName, array $data): void
    {
        $queue = $this->context->createQueue($queueName);
        $queue->addFlag(AmqpQueue::FLAG_DURABLE);
        $this->context->declareQueue($queue);
        $message = $this->context->createMessage(json_encode($data), [
            'content_type' => 'application/json',
        ]);
        $producer = $this->context->createProducer();
        $producer->send($queue, $message);
    }
}