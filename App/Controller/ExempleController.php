<?php

namespace App\Controller;

use Core\View\Template;
use App\Model\ExempleModel;
use Core\Controller\Controller;

/**
 * ExempleController
 * 
 * Responsável por exemplificar uma controller
 * @author Weydans Barros
 * Data de criação: 12/01/2020 
 */

class ExempleController extends Controller
{   
    public function __construct()
    {
        parent::__construct(new Template());
    }


    public function index()
    {
        $this->view('exemple.php');
    }


    public function test()
    {
        $model = new ExempleModel();
        $dados = $model->select()->get();

        $this->responseApi($dados);
    }
}
