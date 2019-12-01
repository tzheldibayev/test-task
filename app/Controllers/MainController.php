<?php

namespace App\Controllers;

use App\Jobs\InitializeJob;

class MainController
{
    public function index()
    {
        $job = new InitializeJob();
        $result = $job->handle();

        if ($result['tableExists'] === true) {
            echo 'table exists';
        }

        
    }
}