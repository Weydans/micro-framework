<?php

use Core\Route;
use App\Controller\ExempleController;
use PHPMailer\PHPMailer\PHPMailer;


$route = new Route('micro-framework/');


$route->get('/', function() {
   $exemple = new ExempleController();
   $exemple->index();
});


$route->get('/test', function() {
    $exemple = new ExempleController();
    $exemple->test();
});


$route->get('/email', function() {
    $mail = new PHPMailer();
    var_dump($mail);
});


$route->get('/validacao', function() {
    $exemple = new ExempleController();
    $exemple->validateUser();
});


$route->run();