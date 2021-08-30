<?php
/**
 * Created by v.taneev.
 */


namespace App\Jobs;


class ScoringRequest implements IncomingJobInterface
{
    protected $inn;
    protected $amount;
    protected $term;
    protected $requestId;

    /**
     * @return mixed
     */
    public function getInn () : string
    {
        return $this->inn;
    }

    /**
     * @return mixed
     */
    public function getAmount () : float
    {
        return (float)$this->amount;
    }

    /**
     * @return mixed
     */
    public function getTerm () : int
    {
        return (int)$this->term;
    }

    /**
     * @return mixed
     */
    public function getRequestId ()
    {
        return $this->requestId;
    }
}
