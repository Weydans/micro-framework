<?php

namespace Core\Validator\Validators;


use Core\Validator\Validators\ISpecializedValidator;

/**
 * Numeric
 * 
 * Responsável por validar se o valor de uma variável é numérico
 * @author Weydans Barros
 * Data de criação 18/01/2020
 */

class Numeric implements ISpecializedValidator
{
    /**
     * validate($param, $rule)
     * 
     * Valida se o valor de um determinado campo é numérico
     * @param $param Valor informado no input do formulário
     * @param $rule  Regra a ser aplicada na validação
     * @param $data  Dados informados a serem validados
     * @return bool  Retorna true caso seja válido
     */
    public function validate($param, $rule = null, array $data = []) : bool
    {
        if (is_numeric($param)) {
            return true;
        }

        return false;
    }
}
