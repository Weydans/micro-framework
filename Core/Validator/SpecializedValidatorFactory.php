<?php

namespace Core\Validator;


use \Exception;
use Core\Validator\ISpecializedValidatorFactory;
use Core\Validator\Validators\ISpecializedValidator;
use Core\Validator\Validators\In;
use Core\Validator\Validators\Min;
use Core\Validator\Validators\Max;
use Core\Validator\Validators\Numeric;
use Core\Validator\Validators\Required;

/**
 * SpecializedValidatorFactory
 * 
 * Fábrica responsável pela criação das instâncias de classes 
 * responsáveis por realizar validação de campos de formulários
 */

class SpecializedValidatorFactory implements ISpecializedValidatorFactory
{
    /**
     * build(string $validator)
     * 
     * Instancia dinamicamente classes de 
     * validação de formulário com base no parâmetro informado
     * @param string $validator Nome da classe a ser instanciada em caixa baixa
     * @return ISpecializedValidator Objeto que implementa ISpecializedValidator
     * @throw Exception caso classe não exista nas validações
     */
    public function build(string $validator) : ISpecializedValidator
    {
        if ($validator == 'required') {
            return new Required();

        } elseif ($validator == 'in') {
            return new In();

        } elseif ($validator == 'min') {
            return new Min();

        } elseif ($validator == 'max') {
            return new Max();

        } elseif ($validator == 'numeric') {
            return new Numeric();

        } else {
            throw new Exception("O validador informado '{$validator}' não existe.");
        }           
    }
}
