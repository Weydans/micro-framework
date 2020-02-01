<?php

namespace Core\Middleware;


use Core\Middleware\IMiddleware;

/**
 * IMiddleware
 * 
 * Fornece contrato para criação de fábicas de middlewares
 */
interface IMiddlewareFactory
{
    /**
     * build(string $middleware)
     * 
     * Instancia dinamicamente classes com papel de middlewares
     * @param string $middleware Nome da classe a ser instanciada em caixa baixa
     * @return IMiddleware Objeto que implementa IMiddleware
     * @throw Exception caso classe não exista
     */
    public function build(string $middleware) : IMiddleware;
}
