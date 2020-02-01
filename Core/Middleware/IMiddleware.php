<?php

namespace Core\Middleware;


/**
 * IMiddleware
 * 
 * Fornece contrato comum entre middlewares do sistema
 */
interface IMiddleware
{
    /* execute()
    * 
    * Executa ação do middleware
    * @param array $request Requisição recebida pelo seridor
    */
    public function execute(&$request);
}
