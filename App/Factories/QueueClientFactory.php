<?php
/**
 * Created by v.taneev.
 */


namespace App\Factories;


use App\Clients\QueueClientInterface;
use App\Clients\RabbitQueueClient;
use App\Configuration;

class QueueClientFactory
{
    /**
     * @return QueueClientInterface
     */
    public static function getClient() : QueueClientInterface {
        $configuration = Configuration::getInstance();
        return RabbitQueueClient::getInstance(
            $configuration->getRabbitHost(),
            $configuration->getRabbitPort(),
            $configuration->getRabbitUser(),
            $configuration->getRabbitPassword(),
        );
    }
}
