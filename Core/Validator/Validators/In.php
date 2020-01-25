<?php

namespace Core\Validator\Validators;


use Core\Validator\Validators\ISpecializedValidator;

/**
 * In
 * 
 * Responsável por validar se o valor informado em um campo 
 * pertence aos valores de um determinado conjunto
 * @author Weydans Barros
 * Data de criação 18/01/2020
 */

class In implements ISpecializedValidator
{
    /**
     * validate($param, $rule)
     * 
     * Valida se o valor de um determinado campo de um 
     * formulário pertence a um conjunto de valores pre aceitos
     * @param $param Valor informado no input do formulário
     * @param $rule  Regra a ser aplicada na validação
     * @param $data  Dados informados a serem validados
     * @return bool  Retorna true caso seja válido
     */
    public function validate($param, $rule = null, array $data = []) : bool
    {
        $arrParams = $this->getArrayParams($rule);

        if (!empty($param) && in_array($param, $arrParams)) {
            return true;
        }

        return false;
    }


    /**
     * getArrayParams(string $ruleString)
     * 
     * Transforma a string de regras de validação em um array 
     * remove os parenteses caso tenham sido informados
     * @param string $ruleString Regra a ser aplicada na validação
     * @return array Conjunto de dados aceitos
     */
    private function getArrayParams(string $ruleString) : array
    {
        $ruleString = str_replace(['(', ')'], '', $ruleString);
        $arrParams  = explode(', ', $ruleString);

        return $arrParams;
    }
}