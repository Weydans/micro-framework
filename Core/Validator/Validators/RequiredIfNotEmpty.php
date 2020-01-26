<?php

namespace Core\Validator\Validators;


use Core\Validator\Validators\ISpecializedValidator;
use Exception;

/**
 * RequiredIfNotEmpty
 * 
 * Responsável por validar se um determinado campo foi preenchido 
 * quando outro determinado campo estiver preenchido
 * @author Weydans Barros
 * Data de criação 26/01/2020
 */
class RequiredIfNotEmpty implements ISpecializedValidator
{
    /**
     * validate($param, $rule)
     * 
     * Valida se um determinado campo foi preenchido 
     * quando outro determinado campo estiver preenchido
     * @param $param Valor informado no input do formulário
     * @param $rule  Regra a ser aplicada na validação
     * @param $data  Dados informados a serem validados
     * @return bool  Retorna true caso seja válido
     * @throw Exception
     */
    public function validate($param, $rule = null, array $data = []) : bool
    {
        if (empty($rule)) {
            throw new Exception("
                'required_if_not_empty' expects a rule like 'required_if_not_empty:param' but 'required_if_not_empty:{$rule}' given
            ");
        }

        if (!isset($data[$rule])) {
            throw new Exception("
                'required_if_not_empty' expects a valid field to compare, 'required_if_not_empty:{$rule}' given
            ");
        }
               
        if ((!empty($param) && !empty($data[$rule])) || empty($data[$rule])) {
            return true;
        }

        return false;
    }
}