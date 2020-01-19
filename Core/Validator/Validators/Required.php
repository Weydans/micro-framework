<?php

namespace Core\Validator\Validators;


use Core\Validator\Validators\ISpecializedValidator;

/**
 * Required
 * 
 * Responsável por validar se o valor de uma variável é 
 * vazio, null, ''(string vazia) ou ' '(string de espaços vazios)
 * @author Weydans Barros
 * Data de criação 18/01/2020
 */

class Required implements ISpecializedValidator
{
    /**
     * validate($param, $rule)
     * 
     * Valida se o valor de um determinado campo foi preenchido
     * @param $param Valor informado no input do formulário
     * @param $rule  Regra a ser aplicada na validação
     * @return bool  Retorna true caso seja válido
     */
    public function validate($param, $rule = null) : bool
    {
        if (!empty(trim($param)) && is_string($param)) {
            return true;
        }

        return false;
    }
}
