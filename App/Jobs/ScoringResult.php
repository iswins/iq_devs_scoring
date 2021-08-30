<?php
/**
 * Created by v.taneev.
 */


namespace App\Jobs;


class ScoringResult implements OutgoingJobInterface
{
    protected $requestId;
    protected $rate;

    public function setRequestId ($requestId): static
    {
        $this->requestId = $requestId;
        return $this;
    }

    public function setRate ($rate): static
    {
        $this->rate = $rate;
        return $this;
    }
}
