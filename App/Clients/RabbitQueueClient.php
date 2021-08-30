<?php
/**
 * Created by v.taneev.
 */


namespace App\Clients;

use App\Services\Interfaces\MessageHandlerInterface;
use Closure;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitQueueClient implements QueueClientInterface
{

    protected string $host;
    protected int $port;
    protected string $user;
    protected string $password;

    protected function __construct($host, $port, $user, $password) {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->password = $password;
    }

    public static function getInstance ($host, $port, $user, $password): static
    {
        return new static($host, $port, $user, $password);
    }

    /**
     * @return string
     */
    public function getHost (): string
    {
        return $this->host;
    }

    /**
     * @return int
     */
    public function getPort (): int
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getUser (): string
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPassword (): string
    {
        return $this->password;
    }

    public function receive ($queueName, MessageHandlerInterface $messageHandler): void
    {
        $connection = $this->connect();
        $channel = $connection->channel();
        $channel->queue_declare($queueName, false, true, false, false);
        $channel->basic_consume(
            $queueName,
            '',
            false,
            false,
            false,
            false,
            function(AMQPMessage $message) use ($messageHandler) {
                $body = json_decode($message->getBody(), true);
                $message->ack();
                try {
                    $messageHandler->handle($body);
                } catch (\Exception $e) {
                    $message->nack();
                }
            }
        );

        while ($channel->is_open()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }

    public function send ($queueName, $data): bool
    {
        $msg = new AMQPMessage(json_encode($data));

        $connection = $this->connect();
        $channel = $connection->channel();
        $channel->queue_declare($queueName, false, true, false, false);
        $channel->basic_publish($msg, '', $queueName);
        $channel->close();
        $connection->close();

        return true;
    }

    /**
     * @return AMQPStreamConnection
     */
    protected function connect() : AMQPStreamConnection {
        return new AMQPStreamConnection(
            $this->getHost(),
            $this->getPort(),
            $this->getUser(),
            $this->getPassword(),
        );
    }
}
