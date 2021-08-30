<?php
/**
 * Created by v.taneev.
 */


namespace App\Services\Interfaces;


interface MessageHandlerInterface
{
    public function __construct(ScoringStrategyInterface $scoringStrategy);

    public function handle($messageBody);
}
