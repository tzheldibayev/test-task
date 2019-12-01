<?php

namespace App\Controllers;

use App\Helpers\Slugger;
use App\Jobs\InitializeJob;

class MainController
{
    public function index()
    {
        $job = new InitializeJob();
        $result = $job->handle();

        if ($result['tableExists'] === true) {
            echo 'table exists' . PHP_EOL;
        }

        foreach ($result['promo'] as $promo) {
            echo Slugger::generate($promo['id'],$promo['name']);
        }


    }
}