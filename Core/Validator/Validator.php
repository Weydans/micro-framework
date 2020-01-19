<?php

namespace Core\Validator;


use Core\Validator\ISpecializedValidatorFactory;

/**
 * Validator
 * 
 * Responsável por acionar validadores 
 * especialistas para campos de formulário
 */

class Validator
{
    private $specializedValidatorFactory;
    private $messages;
    private $fields;
    private $resultErrors;


    /**
     * __construct(ISpecializedValidatorFactory $specializedValidatorFactory, array $messages, array $fields)
     * 
     * Inicializa objeto com configurações necessárias para acionar os validadores especialistas
     * @param ISpecializedValidatorFactory $specializedValidatorFactory Fábrica de validadores especializados
     * @param array $messages Mensagens de erro de validação predefinidas 
     * @param array $fields   Relação de name x label para substituição
     */
    public function __construct(ISpecializedValidatorFactory $specializedValidatorFactory, array $messages, array $fields)
    {
        $this->specializedValidatorFactory = $specializedValidatorFactory;
        $this->messages             = $messages;
        $this->fields               = $fields;
        $this->resultErrors         = [];
    }


    /**
     * validate(array $data, array $validators)
     * 
     * Gerencia processo de validação chamando métodos especialistas 
     * @param array $data       Dados a serem validados
     * @paramarray $validators  Regras a serem aplicadas
     * @return array            Lista de menságens de dados inválidos
     */
    public function validate(array $data, array $validators) : array
    {
        foreach ($validators as $key => $singleRule) {
            $fieldValue    = $data[$key];
            $arrValidators = explode('|', $singleRule);

            foreach ($arrValidators as $rule) {
                $isValid = $this->execute($fieldValue, $rule);

                if (!$isValid) {
                    $this->resultErrors[$key][] = $this->setResultErrors($isValid, $key, $fieldValue, $rule);
                }
            }
        }   

        return $this->prepareResponse();
    }


    /**
     * gerResultErrors()
     * 
     * Retorna valor do atributo resultErrors
     * @return $this->resultErrors Resultado dos campos iválidos
     */
    public function gerResultErrors() : array
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

        return $specializedValidator->validate($fieldValue, $rule);
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
                'message' => $this->setMessage($bind, $rule)
            ];
        }

        return $result;
    }


    /**
     * setMessage(string $bind, string $rule)
     * 
     * Monta menságem de resultado da 
     * validação de cada campo não que inválido
     * @param string $bind Valor da propriedade name do input
     * @param string $rule Regra a ser aplicada
     * @return string $message Menságem a ser exibida
     */
    private function setMessage(string $bind, string $rule) : string
    {
        $aux = explode(':', $rule);

        $ruleName  = $aux[0];
        $ruleParam = isset($aux[1]) ? $aux[1] : '';

        $message = null;
        if (in_array($ruleName, array_keys($this->messages))) {
            $message = $this->messages[$ruleName];
        }

        $field = null;
        if (in_array($bind, array_keys($this->fields))) {
            $field = $this->fields[$bind];
        } else {
            $field = $bind;
        }

        $message = str_replace('{field}', $field,     $message);
        $message = str_replace('{param}', $ruleParam, $message);

        return $message;
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
