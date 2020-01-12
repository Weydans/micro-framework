<?php

namespace Core\Controller;

use Core\View\ITemplate;
use Core\Controller\BaseController;

/**
 * Controller
 * 
 * Controller default, serve de 
 * base para todos os cotrollers da aplicação
 * @author Weydans Barros
 * Data de criação: 12/01/2020
 */

abstract class Controller extends BaseController
{
    /**
     * @var ITemplate $template
     */
    protected $template;


    protected function __construct(ITemplate $template)
    {
        $this->template = $template;
    }


    public function view(string $view, array $dados = []) : void
    {
        $this->template->view($view, $dados);
    }


    public function responseApi(array $dados) : void
    {
        if (count($dados) > 0) {
            echo json_encode($dados);
        } else {
            echo '';
        }
    }
}
