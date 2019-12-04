<?php

namespace App\Controllers;

use App\Models\Promo;
use Core\Controller;

class PromoController extends Controller
{
    protected $viewPath = 'promo';
    protected $viewFile = 'show';

    /**
     * @param $slug
     */
    public function show($slug)
    {
        $model = new Promo();
        $data = $model->getBuilder()
            ->select($model->getTable(), $model->getAttributes())
            ->where('slug', '=', $slug)
            ->get();

        if (empty($data)) {
            header('HTTP/1.0 404 Not Found');
            echo 'The requested page not found.';
        }

        $this->render($data);
    }
}