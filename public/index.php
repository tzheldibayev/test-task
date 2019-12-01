<?php
define('display_errors', 1);
require __DIR__.'/../vendor/autoload.php';

$config = __DIR__.'/../config/app.php';

//Create a new router instance.
$router = new \Core\Router\Router();

// Rules
$router->addRoute('/', 'App\Controllers\MainController@index');
$router->addRoute('/promo/(\w+)', 'App\Controllers\PromoController@show');
$router->set404(function(){
    echo 'The requested page not found.';
});

$app = new \Core\Application($router, $config);
$app->bootstrap();