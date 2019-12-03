<?php

namespace App\Controllers;

use App\Helpers\Slugger;
use App\Models\Promo;
use Core\Controller;

/**
 * Class MainController
 * @package App\Controllers
 */
class MainController extends Controller
{
    public function index()
    {
        $model = new Promo();

        $data = [];

        $builder = $model->getBuilder();
        $tableExists = $builder->tableExists('promo');

        if ($tableExists) {
            $data['tableExists'] = true;
        } else {
            $model->createTable();
        }

        $model->getBuilder()->truncate($model->getTable());
        $model->exportDataFromCsv();

        $data['randomPromo'] = $model->getRandomModel();

        $models = $model->getBuilder()->select($model->getTable(), $model->getAttributes())->get();
        foreach ($models as $model) {
            $data['promotions'][] = $model;
//            $data['promotions'][] = 'http://localhost/promo/' . Slugger::generate($model['id'], $model['name']);
        }

        $this->render($data);

    }
}