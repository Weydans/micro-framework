<?php

namespace Core\Validator\Validators;

use Core\Validator\Validators\ISpecializedValidator;

/**
 * Min
 * 
 * Responsável por validar se o tamanho mínimo de uma string
 * @author Weydans Barros
 * Data de criação 18/01/2020
 */

class Min implements ISpecializedValidator
{
    /**
     * validate($param, $rule)
     * 
     * Valida se o valor de um determinado campo 
     * é superior a um valor determinado por uma regra
     * @param $param Valor informado no input do formulário
     * @param $rule  Regra a ser aplicada na validação
     * @param $data  Dados informados a serem validados
     * @return bool  Retorna true caso seja válido
     */
    public function validate($param, $rule = null, array $data = []) : bool
    {
        if (empty($param) || strlen($param) >= $rule) {
            return true;
        }

        return false;
    }
}
