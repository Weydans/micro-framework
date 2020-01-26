<?php

namespace Core\Validator;


use \Exception;
use Core\Validator\ISpecializedValidatorFactory;
use Core\Validator\Validators\ISpecializedValidator;

/**
 * SpecializedValidatorFactory
 * 
 * Fábrica responsável pela criação das instâncias de classes 
 * responsáveis por realizar validação de campos de formulários
 */
class SpecializedValidatorFactory implements ISpecializedValidatorFactory
{
    const VALIDATOR_BASE_NAMESPACE = 'Core\Validator\Validators\\';

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
        $classValidator = $this->getClassValidator($validator);

        try {
            if (class_exists($classValidator)) {
                return new $classValidator();
            }

        } catch (Exception $e) {
            throw new Exception("Validator not found '{$validator}'");         
        }        
    }


    /**
     * getClassValidator(string $validator)
     * 
     * Monta fully qualified name da classe a ser instanciada
     * @param  string $validator nome do validador
     * @return string fully qualified name da classe
     */
    private function getClassValidator(string $validator) : string
    {
        $classValidator = str_replace(' ', '', ucwords(str_replace(['_', '-'], ' ', $validator)));

        return self::VALIDATOR_BASE_NAMESPACE . $classValidator;
    }
}
