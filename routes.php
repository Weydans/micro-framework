<?php

use Core\Route;
use App\Controller\ExempleController;
use PHPMailer\PHPMailer\PHPMailer;


try {    
    $route = new Route('micro-framework/');


    $route->get('/', function() {
    $exemple = new ExempleController();
    $exemple->index();
    }, ['Admin']);


    $route->get('/email', function() {
        $mail = new PHPMailer();
        var_dump($mail);
    });


    $route->middleware(['Auth'], function($route) {

        $route->get('/validacao', function() {
            $exemple = new ExempleController();
            $exemple->validateUser();
        });

        $route->get('/email', function() {
            $mail = new PHPMailer();
            var_dump($mail);
        });
    });


    $route->group('/validacao', ['auth', 'Admin'], function($route) {
        
        $route->get('/test', function() {
            $exemple = new ExempleController();
            $exemple->validateUser();
        });
        
        $route->get('/email', function() {
            $mail = new PHPMailer();
            var_dump($mail);
        });
    });


    $route->get('/test', function() {
        $exemple = new ExempleController();
        $exemple->test();
    });


    $route->run();

} catch (Exception $e) {
    throw new Exception($e->getMessage());    
}