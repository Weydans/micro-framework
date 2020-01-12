<?php

namespace Core\Controller;

use Core\View\ITemplate;

/**
 * BaseController
 * 
 * Classe abstrata por fornecer uma 
 * interface comum a todos os controllers da aplicação
 * @author Weydans Barros
 * Data de criação: 12/01/2020
 */

abstract class BaseController
{
    protected abstract function __construct(ITemplate $template);
    
    public abstract function responseApi(array $dados) : void;
    public abstract function view(string $view, array $dados) : void;
}
