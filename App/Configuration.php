<?php
/**
 * Created by v.taneev.
 */


namespace App;


class Configuration
{
    protected static Configuration $instance;

    protected array $envConfig = [];

    protected function __construct() {
        $this->envConfig = getenv();
    }

    public static function getInstance() : static {
        return static::$instance ?? static::$instance = new static();
    }

    public function getRabbitHost() {
        return $this->envConfig['RABBITMQ_HOST'] ?? 'localhost';
    }

    public function getRabbitPort() {
        return $this->envConfig['RABBITMQ_PORT'] ?? '5672';
    }

    public function getRabbitUser() {
        return $this->envConfig['RABBITMQ_USER'] ?? null;
    }

    public function getRabbitPassword() {
        return $this->envConfig['RABBITMQ_PASSWORD'] ?? null;
    }

    public function getQueueRead() {
        return $this->envConfig['RABBITMQ_QUEUE_READ'] ?? 'scoring_requests';
    }

    public function getQueueWrite() {
        return $this->envConfig['RABBITMQ_QUEUE_WRITE'] ?? 'scoring_results';
    }
}
