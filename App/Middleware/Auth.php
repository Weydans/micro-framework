<?php

namespace App\Middleware;


use Core\Middleware\IMiddleware;

/**
 * Auth
 * 
 * Responsável por verificar se um 
 * usuário está autenticado no sistema
 */
class Auth implements IMiddleware
{
    /**
     * execute()
     * 
     * Executaação de verificação do middleware
     * @param array $request Requisição recebida pelo seridor
     */
    public function execute(&$request)
    {
        // die('Stop in Auth');
        echo 'Auth';
    }
}
