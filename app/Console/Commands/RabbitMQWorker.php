<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Support\RabbitMQPublisher;
use App\Jobs\SendActivationEmailJob;
use Interop\Amqp\AmqpQueue;

class RabbitMQWorker extends Command
{
    protected $signature = 'rabbitmq:work';
    protected $description = 'Listen to RabbitMQ and dispatch jobs';

    public function handle(RabbitMQPublisher $rabbitMQ)
    {
        $context = $rabbitMQ->getContext();
        $queue = $context->createQueue('activation_email_queue');

        
        $queue->addFlag(AmqpQueue::FLAG_DURABLE);
        $context->declareQueue($queue);

        $consumer = $context->createConsumer($queue);

        $this->info('Listening to RabbitMQ queue: activation_email_queue...');

        while (true) {
            if ($message = $consumer->receive(2000)) {
                $data = json_decode($message->getBody(), true);

                dispatch(new SendActivationEmailJob($data['email'], $data['url'], $data['fullname']));

                $consumer->acknowledge($message);
            }
        }
    }
}
