<?php

namespace App\Controllers;

use Core\Controller;

class PromoController extends Controller
{
    public function show($slug)
    {
        echo 'Your: ' . $slug;
    }
}