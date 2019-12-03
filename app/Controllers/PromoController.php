<?php

namespace App\Controllers;

use App\Models\Promo;
use Core\Controller;

class PromoController extends Controller
{
    protected $viewPath = 'promo';
    protected $viewFile = 'show';

    public function show($slug)
    {
        $model = new Promo();
//        $model->getBuilder()->where('')

    }
}