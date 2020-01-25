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


    public function validateUser()
    {
        $data = [
            'name'          => 'Weydans Campos de Barros',
            'password'      => '123456',
            'email'         => 'weydans@email.com',
            'zipcode'       => '35170-237',
            'date'          => '2020-01-19',
            'street'        => 'Pedras preciosas',
            'city'          => 'Coronel Fabriciano',
            'number'        => '124',
            'neighborhood'  => 'Pedra Linda',
            'state'         => '',
            'country'       => 'Brasil',
            'motrher-name'  => 'Elza de Fátima Campos de Barros',
            'father-name'   => 'Messias Benevenuto de Barros',
            'ocupation'     => 'Student',
        ];

        $model    = new ExempleModel();
        $response = $model->validateUser($data);

        $this->view('validations.php', [
            'res' => $response
        ]);
    }
}
