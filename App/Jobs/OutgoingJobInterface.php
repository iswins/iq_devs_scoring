<?php
/**
 * Created by v.taneev.
 */


namespace App\Jobs;


interface OutgoingJobInterface
{
    public function setRequestId($requestId) : static;
    public function setRate($rate) : static;
}
