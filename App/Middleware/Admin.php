<?php

namespace App\Middleware;

use Core\Middleware\IMiddleware;

class Admin implements IMiddleware
{
    public function execute(&$request)
    {
        // die('Stop in Admin');
        // echo 'Admin';
    }
}
