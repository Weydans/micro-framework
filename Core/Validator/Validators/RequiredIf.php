<?php

namespace Core\Validator\Validators;


use Core\Validator\Validators\ISpecializedValidator;
use Exception;

/**
 * Required
 * 
 * Responsável por validar se o valor de um determinado campo foi preenchido
 * quando um outro campo está preenchido com um determinado valor
 * @author Weydans Barros
 * Data de criação 25/01/2020
 */
class RequiredIf implements ISpecializedValidator
{
    /**
     * validate($param, $rule)
     * 
     * Valida se o valor de um determinado campo foi preenchido
     * quando um outro campo está preenchido com um determinado valor
     * @param $param Valor informado no input do formulário
     * @param $rule  Regra a ser aplicada na validação
     * @param $data  Dados informados a serem validados
     * @return bool  Retorna true caso seja válido
     * @throw Exception
     */
    public function validate($param, $rule = null, array $data = []) : bool
    {
        if (!strpos($rule, '=') > 0) {
            throw new Exception("
                'required_if' expects a confirm rule like 'required_if:param=value' but 'required_if:{$rule}' given
            ");
        }
        
        list($field, $value) = explode('=', $rule);

        if (strpos($value, ',') > 0) {
            list($value, $visibleValue) = explode(',', $value);
        }
        
        if (!array_key_exists($field, $data)) {
            throw new Exception("validator field not found 'required_if:{$rule}'");
        }
        
        if (empty($value)) {
            throw new Exception("validator expects one parameter after 'required_if:{$rule}'");
        }
        
        if (($data[$field] != $value) || ($data[$field] == $value && !empty($param))) {
            return true;
        }

        return false;
    }
}
