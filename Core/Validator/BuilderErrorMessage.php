<?php

namespace Core\Validator;


use Core\Validator\IBuilderErrorMessage;

/**
 * BuilderErrorMessage
 * 
 * Responsável por montar mensagem de erro para validação de formulários
 * @author Weydans Barros
 * Data de criação: 26/01/2020
 */
class BuilderErrorMessage implements IBuilderErrorMessage
{
    private $messages;
    private $fields;


    /**
     * __construct(array $messages, array $fields)
     * 
     * Inicializa objeto com configurações necessárias para montar mensagem de erro
     * @param array $messages Mensagens de erro de validação predefinidas 
     * @param array $fields   Relação de name x label para substituição
     */
    public function __construct(array $messages = VALIDATOR_MESSAGES_DEFAULT, array $fields = VALIDATOR_FIELDS_DEFAULT)
    {
        $this->messages = $messages;
        $this->fields   = $fields;
    }


    /**
     * mount(string $bind, string $rule)
     * 
     * Monta menságem de resultado da 
     * validação de cada campo não que inválido
     * @param string $bind Valor da propriedade name do input
     * @param string $rule Regra a ser aplicada
     * @return string $message Menságem a ser exibida
     */
    public function build(string $bind, string $rule) : string
    {
        $aux = explode(':', $rule);

        $ruleName = $aux[0];
        $param    = isset($aux[1]) ? $aux[1] : '';

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

        $value = null;
        if (strpos($param, '=') > 0) {
            list($param, $value) = explode('=', $param);

            if (strpos($value, ',') > 0) {
                list($realValue, $value) = explode(',', $value);
            }
        }
        
        if (!empty($param) && in_array($param, array_keys($this->fields))) {
            $param = $this->fields[$param];
        }

        $message = str_replace('{field}', $field, $message);
        $message = str_replace('{param}', $param, $message);
        $message = str_replace('{value}', $value, $message);

        return $message;
    }
}