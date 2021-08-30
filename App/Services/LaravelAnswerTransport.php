<?php
/**
 * Created by v.taneev.
 */


namespace App\Services;


use App\Clients\QueueClientInterface;
use App\Jobs\OutgoingJobInterface;
use App\Jobs\ScoringResult;
use App\Services\Interfaces\AnswerTransportInterface;

class LaravelAnswerTransport implements AnswerTransportInterface
{

    protected QueueClientInterface $client;
    protected string $queueName;

    public function __construct (QueueClientInterface $client, $queueName)
    {
        $this->client = $client;
        $this->queueName = $queueName;
    }

    /**
     * @return QueueClientInterface
     */
    public function getClient (): QueueClientInterface
    {
        return $this->client;
    }

    /**
     * @return string
     */
    public function getQueueName (): string
    {
        return $this->queueName;
    }

    public function answer ($requestId, $rate)
    {
        $response = new ScoringResult();
        $response->setRequestId($requestId);
        $response->setRate($rate);

        $ret = [
            'uuid' => uniqid(),
            'displayName' => $response::class,
            'job' => 'Illuminate\Queue\CallQueuedHandler@call',
            'maxTries' => null,
            'maxExceptions' => null,
            'failOnTimeout' => false,
            'backoff' => null,
            'timeout' => null,
            'retryUntil' => null,
            'data' => [
                'commandName' => $response::class,
                'command' => serialize(clone $response)
            ],
            'id' => uniqid()
        ];

        $this->getClient()->send($this->getQueueName(), $ret);
    }
}
