<?php

namespace App\Middleware;

use Core\Middleware\IMiddleware;

class Auth implements IMiddleware
{
    public function execute(&$request)
    {
        // die('Stop in Auth');
        echo 'Auth';
    }
}
