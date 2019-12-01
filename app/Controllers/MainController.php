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
            echo 'Table exists' . '<br>';
        }

        echo '<pre>';
        print_r($result['randomRow']);

        foreach ($result['promo'] as $promo) {
            echo '<br>';
            echo Slugger::generate($promo['id'],$promo['name']);
        }

    }
}