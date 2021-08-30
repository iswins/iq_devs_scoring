<?php
/**
 * Created by v.taneev.
 */


namespace App\Services\Interfaces;


use App\Clients\QueueClientInterface;
use App\Jobs\OutgoingJobInterface;

interface AnswerTransportInterface
{
    public function __construct(QueueClientInterface $client, $queueName);
    public function answer($requestId, $rate);
}
