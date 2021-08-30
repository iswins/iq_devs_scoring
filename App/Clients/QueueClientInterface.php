<?php
/**
 * Created by v.taneev.
 */


namespace App\Clients;

use App\Services\Interfaces\MessageHandlerInterface;

interface QueueClientInterface
{
    public function receive ($queueName, MessageHandlerInterface $messageHandler): void;

    public function send($queueName, $data) : bool;
}
