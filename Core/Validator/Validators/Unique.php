<?php

namespace Core\Validator\Validators;


use Core\Validator\Validators\ISpecializedValidator;
use Core\DAO\DB;
use Exception;

/**
 * Unique
 * 
 * Responsável por validar se um determinado 
 * campo terá um valor único na base de dados
 * @author Weydans Barros
 * Data de criação 24/01/2020
 */
class Unique implements ISpecializedValidator
{
    /**
     * validate($param, $rule, data)
     * 
     * Valida se o valor um determinado campo é unico em uma determinada tabela
     * @param $param Valor informado no input do formulário
     * @param $rule  Regra a ser aplicada na validação
     * @param $data  Dados informados a serem validados
     * @return bool  Retorna true caso seja válido
     */
    public function validate($param, $rule = null, array $data = []) : bool
    {
        $numOccurrences = count(DB::select($rule)->where(array_search($param, $data), $param)->get());

        if (empty($data['id']) && $numOccurrences == 0) {
            return true;
        }
        
        if (!empty($data['id']) && DB::select($rule)->where(array_search($param, $data), $param)->where('id', $data['id'])->first()['id'] == $data['id']) {
            return true;
        }

        return false;
    }
}