<?php

namespace App\Model;


use \Exception;
use Core\Model\Model;
use Core\Validator\Validator;
use Core\Validator\SpecializedValidatorFactory;

/**
 * ExempleModel
 * 
 * Classe de exemplo de Modelo
 * @author Weydans Barros
 * Data de criação: 27/12/2019
 */
class ExempleModel extends Model
{
    private $validator;
    protected $table = 'tarefa';

    public function __construct()
    {
        $this->validator = new Validator(new SpecializedValidatorFactory(), VALIDATOR_MESSAGES_DEFAULT, VALIDATOR_FIELDS_DEFAULT);
    }


    /**
     * validateUser($data)
     * 
     * Valida dados de usuário
     * @param array $data Dados do ususário
     * @return array Menságens de campos inválidos
     */
    public function validateUser(array $data) : array
    {
        $validations = [
            'name'          => 'required|min:5|numeric',
            'password'      => 'required|numeric|min:4|max:255',
            'email'         => 'required|min:5|max:15',
            'zipcode'       => 'numeric',
            'date'          => 'required|numeric|min:50',
            'street'        => 'required|numeric',   
            'city'          => 'required|numeric',
            'number'        => 'numeric',
            'neighborhood'  => 'required|min:3|max:255',
            'country'       => 'required|min:2|max:255',
            'state'         => 'required_if:country=Brasil|min:2|max:255',
            'motrher-name'  => 'required|min:2|max:255',
            'father-name'   => 'required|min:2|max:255',
            'ocupation'     => 'required|min:2|max:255',       
        ];
        
        return $this->validator->validate($data, $validations);
        // var_dump($this->validator->gerResultErrors());
    }
}
