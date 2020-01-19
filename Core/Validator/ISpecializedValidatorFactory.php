<?php

namespace Core\Validator;


use Core\Validator\Validators\ISpecializedValidator;

/**
 * ISpecializedValidatorFactory
 * 
 * Responsável por fornecer interface comum 
 * para classes fabricas de validadores de formulário
 */

interface ISpecializedValidatorFactory
{
    /**
     * build(string $validator)
     * 
     * Instancia dinamicamente classes de 
     * validação de formulário com base no parâmetro informado
     * @param string $validator Nome da classe a ser instanciada em caixa baixa
     * @return ISpecializedValidator Objeto que implementa ISpecializedValidator
     */
    public function build(string $validator) : ISpecializedValidator;
}
