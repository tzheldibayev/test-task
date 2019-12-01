<?php
define('display_errors', 1);
require __DIR__.'/../vendor/autoload.php';

//Create a new router instance.
$router = new \Core\Router();

// Rules
$router->addRoute('/', function() {
    echo 'hello world';
});
$router->addRoute('/promo/(\w+)', 'App\Controllers\PromoController@show');
$router->set404(function(){
    echo 'The requested page not found.';
});


$router->run();