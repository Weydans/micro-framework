<?php

namespace Core\Middleware;


use Core\Middleware\IMiddleware;

interface IMiddlewareFactory
{
    public function build(string $middleware) : IMiddleware;
}
