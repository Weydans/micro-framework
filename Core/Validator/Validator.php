<?php

namespace Core\Validator;


use Core\Validator\BuilderErrorMessage;
use Core\Validator\IBuilderErrorMessage;
use Core\Validator\SpecializedValidatorFactory;
use Core\Validator\ISpecializedValidatorFactory;

/**
 * Validator
 * 
 * Responsável por acionar validadores 
 * especialistas para campos de formulário
 * @author Weydans Barros
 * Data de criação 18/01/2020
 */
class Validator
{
    private $specializedValidatorFactory;
    private $data;
    private $messageBuilder;
    private $resultErrors;
    private $errorMessages;


    /**
     * __construct(ISpecializedValidatorFactory $specializedValidatorFactory, array $messages, array $fields)
     * 
     * Inicializa objeto com configurações necessárias para acionar os validadores especialistas
     * @param ISpecializedValidatorFactory $specializedValidatorFactory Fábrica de validadores especializados
     */
    public function __construct(ISpecializedValidatorFactory $specializedValidatorFactory = null, IBuilderErrorMessage $messageBuilder = null) 
    {
        $this->errorMessages               = [];
        $this->resultErrors                = [];
        $this->messageBuilder              = !empty($messageBuilder)              ? $messageBuilder              : new BuilderErrorMessage();
        $this->specializedValidatorFactory = !empty($specializedValidatorFactory) ? $specializedValidatorFactory : new SpecializedValidatorFactory();
    }


    /**
     * validate(array $data, array $validations)
     * 
     * Gerencia processo de validação chamando métodos especialistas 
     * @param array $data        Dados a serem validados
     * @paramarray $validations  Regras a serem aplicadas
     * @return array             Lista de menságens de dados inválidos
     */
    public function validate(array $data, array $validations) : bool
    {
        $this->data = $data;

        foreach ($validations as $key => $singleRule) {
            $fieldValue     = $data[$key];
            $arrValidations = explode('|', $singleRule);

            foreach ($arrValidations as $rule) {
                $isValid = $this->execute($fieldValue, $rule);

                if (!$isValid) {
                    $this->resultErrors[$key][] = $this->setResultErrors($isValid, $key, $fieldValue, $rule);
                }
            }
        }   

        $this->errorMessages = $this->prepareResponse();

        if (count($this->errorMessages) > 0) {
            return false;
        }

        return true;
    }


    /**
     * getErrorMessages()
     * 
     * Retorna valor do atributo resultErrors
     * @return $this->resultErrors Resultado dos campos iválidos
     */
    public function getErrorMessages() : array
    {
        return $this->errorMessages;
    }


    /**
     * getResultErrors()
     * 
     * Retorna valor do atributo resultErrors
     * @return $this->resultErrors Resultado dos campos iválidos
     */
    public function getResultErrors() : array
    {
        return $this->resultErrors;
    }


    /**
     * executeSingleRule(string $nameSpecilizedValidator, $value, string $rule = null)
     * 
     * Aciona validador especialisado de regra simple (que não dependem de parâmetros)
     * @param string $nameSpecilizedValidator Nome do validador especializado em caixa baixa
     * @param string $value Valor a ser validado
     * @return bool 
     */
    private function executeSingleRule(string $nameSpecilizedValidator, string $value) : bool
    {
        $specializedValidator = $this->specializedValidatorFactory->build($nameSpecilizedValidator);
        return $specializedValidator->validate($value);
    }


    /**
     * executeRuleWithParam(string $fieldValue, string $rule)
     * 
     * Aciona validador especialisado de regra com parâmetro(s)
     * @param string $fieldValue Nome do validador especializado em caixa baixa
     * @param string $rule Valor a ser validado
     * @return bool 
     */
    private function executeRuleWithParam(string $fieldValue, string $rule) : bool
    {
        $nameSpecilizedValidator = substr($rule, 0, strpos($rule, ':', 0));
        $rule                    = substr($rule, strpos($rule, ':', 0) + 1, strlen($rule)); 
        $specializedValidator    = $this->specializedValidatorFactory->build($nameSpecilizedValidator);

        return $specializedValidator->validate($fieldValue, $rule, $this->data);
    }


    /**
     * execute(string $fieldValue, string $rule)
     * 
     * Identifica tipo de validação e executar regra apropriada
     * @param string $fieldValue Valor a ser validado
     * @param string $rule       Regra a ser Aplicada
     * @return bool 
     */
    private function execute(string $fieldValue, string $rule) : bool
    {
        if (strpos($rule, ':', 0) > 0) {
            return $this->executeRuleWithParam($fieldValue, $rule);

        } else {
            return $this->executeSingleRule($rule, $fieldValue);
        }
    }


    /**
     * setResultErrors($response, $bind, $rule)
     * 
     * Monta resultado da validação
     * @param bool $response       Resposta das validações
     * @param string $bind         Campo validados
     * @param string $fieldValue   Valor que foi validado
     * @param string $rule         Regra aplicada
     * @return array $result       Resultado da validação
     */
    private function setResultErrors(bool $response, string $bind, string $fieldValue, string $rule) : array
    {
        $result = [];

        if (!$response) {
            $result = [
                'valid'   => false,
                'rule'    => $rule,
                'value'   => $fieldValue,
                'message' => $this->messageBuilder->build($bind, $rule)
            ];
        }

        return $result;
    }


    /**
     * prepareResponse()
     * 
     * Monta array de menságens de campos inválidos
     * @return array $result Menságens de campos inválidos
     */
    private function prepareResponse() : array
    {
        $result = [];

        if (count($this->resultErrors) > 0) {
            foreach ($this->resultErrors as $key => $field) {
                foreach ($field as $value) {
                    $result[] = $value['message'];
                };
            }
        }

        return $result;
    }
}
