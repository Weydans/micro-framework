<?php

namespace App\Middleware;


use Core\Middleware\IMiddleware;

/**
 * Admin
 * 
 * Responsável por verificar se um 
 * usuário possui perfil de administrador 
 */
class Admin implements IMiddleware
{
    /**
     * execute()
     * 
     * Executaação de verificação do middleware
     * @param array $request Requisição recebida pelo seridor
     */
    public function execute(&$request)
    {
        // die('Stop in Admin');
        echo 'Admin';
    }
}
