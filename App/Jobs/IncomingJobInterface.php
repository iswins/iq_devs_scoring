<?php
/**
 * Created by v.taneev.
 */


namespace App\Jobs;


interface IncomingJobInterface
{
    public function getInn() : string;
    public function getAmount() : float;
    public function getTerm() : int;
    public function getRequestId();
}
