<?php

namespace App\Controllers;

use App\Jobs\InitializeJob;

class MainController
{
    public function index()
    {
        $job = new InitializeJob();
        $result = $job->handle();

        if ($result['tableExists']) {
            echo 'table exists';
        }
        echo 'table not exists';
    }
}