<?php

namespace App\Jobs;

interface Job
{
    /**
     * @return bool
     */
    public function handle();
}