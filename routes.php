<?php

use Core\Route;
use App\Controller\ExempleController;


$route = new Route('micro-framework/');


$route->get('/', function() {
   $exemple = new ExempleController();
   $exemple->index();
});


$route->get('/test', function() {
    $exemple = new ExempleController();
    $exemple->test();
});


$route->run();