<?php

namespace Core\Validator\Validators;


/**
 * ISpecializedValidator
 * 
 * Responsável por fornecer interface comum 
 * para classes de validação de campos de formulários
 */

interface ISpecializedValidator
{
    /**
     * validate($param, $rule)
     * 
     * Valida se o valor de um determinado 
     * campo de formulário atende a uma determinada regra
     * @param $param Valor informado no input do formulário
     * @param $rule  Regra a ser aplicada na validação
     * @param $data  Dados informados a serem validados
     * @return bool  Retorna true caso seja válido
     */
    public function validate($param, $rule = null, array $data = []) : bool;
}
