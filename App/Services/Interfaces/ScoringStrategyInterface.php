<?php
/**
 * Created by v.taneev.
 */


namespace App\Services\Interfaces;


use App\Jobs\IncomingJobInterface;

interface ScoringStrategyInterface
{
    public function __construct(AnswerTransportInterface $answerTransport);
    public function run(IncomingJobInterface $request);
}
