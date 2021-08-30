<?php
/**
 * Created by v.taneev.
 */


namespace App\Commands;


use App\Configuration;
use App\Factories\QueueClientFactory;
use App\Services\LaravelAnswerTransport;
use App\Services\LaravelMessageHandler;
use App\Services\SimpleScoringStrategy;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class QueueWorkCommand extends Command
{
    public function configure ()
    {
        $this->setName("queue:handle");
    }

    public function execute (InputInterface $input, OutputInterface $output)
    {
        $configuration = Configuration::getInstance();
        $client = QueueClientFactory::getClient();

        $answerTransport = new LaravelAnswerTransport($client, $configuration->getQueueWrite());
        $strategy = new SimpleScoringStrategy($answerTransport);
        $laravelIncomingHandler = new LaravelMessageHandler($strategy);

        $client->receive(
            $configuration->getQueueRead(),
            $laravelIncomingHandler
        );
    }
}
