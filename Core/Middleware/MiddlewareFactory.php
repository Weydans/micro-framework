<?php

namespace Core\Middleware;

use \Exception;
use Core\Middleware\IMiddleware;
use Core\Middleware\IMiddlewareFactory;

/**
 * SpecializedValidatorFactory
 * 
 * Fábrica responsável pela criação das instâncias de classes 
 * responsáveis por realizar validação de campos de formulários
 */
class MiddlewareFactory implements IMiddlewareFactory
{
    const BASE_NAMESPACE = 'App\\Middleware\\';

    /**
     * build(string $middleware)
     * 
     * Instancia dinamicamente classes de 
     * validação de formulário com base no parâmetro informado
     * @param string $middleware Nome da classe a ser instanciada em caixa baixa
     * @return ISpecializedValidator Objeto que implementa ISpecializedValidator
     * @throw Exception caso classe não exista nas validações
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
