<?php

namespace App\Controllers;

use App\Helpers\Slugger;
use App\Models\Promo;

/**
 * Class MainController
 * @package App\Controllers
 */
class MainController
{
    public function index()
    {
        $model = new Promo();

        $builder = $model->getBuilder();
        $tableExists = $builder->tableExists('promo');

        if ($tableExists) {
            echo 'Table exists' . '<br>';
        } else {
            $model->createTable();
        }

        $model->getBuilder()->truncate($model->getTable());
        $model->exportDataFromCsv();

        echo '<pre>';
        print_r($model->getRandomModel());

        $models = $model->getBuilder()->select($model->getTable(), $model->getAttributes())->get();
        foreach ($models as $model) {
            echo '<br>';
            echo Slugger::generate($model['id'], $model['name']);
        }

    }
}