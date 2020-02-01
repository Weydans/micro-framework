<?php

namespace Core\Middleware;

use \Exception;
use Core\Middleware\IMiddleware;
use Core\Middleware\IMiddlewareFactory;

/**
 * MiddlewareFactory
 * 
 * Fábrica responsável pela criação das instâncias de 
 * classes responsáveis por realizar funções de middlewares
 */
class MiddlewareFactory implements IMiddlewareFactory
{
    const BASE_NAMESPACE = 'App\\Middleware\\';

    /**
     * build(string $middleware)
     * 
     * Instancia dinamicamente classes com papel de middlewares
     * @param string $middleware Nome da classe a ser instanciada em caixa baixa
     * @return IMiddleware Objeto que implementa IMiddleware
     * @throw Exception caso classe não exista
     */
    public function build(string $middleware) : IMiddleware
    {
        $className = $this->getClassName($middleware);

        try {
            if (class_exists($className)) {
                return new $className();
            }

        } catch (Exception $e) {
            throw new Exception("Middleware not found '{$middleware}'");         
        }        
    }

    /**
     * getClassName(string $middleware)
     * 
     * Monta fully qualified name da classe a ser instanciada
     * @param  string $middleware nome do middleware
     * @return string fully qualified name da classe
     */
    private function getClassName(string $middleware) : string
    {
        $className = ucfirst($middleware);

        return self::BASE_NAMESPACE . $className;
    }
}
