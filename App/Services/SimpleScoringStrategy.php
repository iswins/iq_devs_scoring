<?php
/**
 * Created by v.taneev.
 */


namespace App\Services;

use App\Jobs\IncomingJobInterface;
use App\Services\Interfaces\AnswerTransportInterface;
use App\Services\Interfaces\ScoringStrategyInterface;

class SimpleScoringStrategy implements ScoringStrategyInterface
{
    const RESULT_DELAY = 10;
    const DELAY_RATE = 61;

    protected AnswerTransportInterface $answerTransport;

    public function __construct (AnswerTransportInterface $answerTransport)
    {
        $this->answerTransport = $answerTransport;
    }

    /**
     * @return AnswerTransportInterface
     */
    public function getAnswerTransport (): AnswerTransportInterface
    {
        return $this->answerTransport;
    }


    public function run (IncomingJobInterface $request)
    {
        $indicator = (int)substr($request->getInn(), -2);

        if ($indicator >= static::DELAY_RATE) {
            return $this->delayProcess($indicator, $request);
        }

        return $this->getAnswerTransport()
            ->answer($request->getRequestId(), $indicator);
    }

    protected function delayProcess($indicator, IncomingJobInterface $request) {
        $amount = $request->getAmount();
        $transport = $this->getAnswerTransport();

        sleep(static::RESULT_DELAY);
        if ($amount % 2 == 0) {
            return $transport->answer($request->getRequestId(), $indicator);
        }

        return $transport->answer($request->getRequestId(), 0);
    }
}
