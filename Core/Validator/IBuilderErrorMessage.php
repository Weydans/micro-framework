<?php

namespace Core\Validator;

/**
 * IBuilderErrorMessage
 * 
 * Fornece método padrão para construção de 
 * mensagem de erro de validação de formulário
 * @author Weydans Barros
 * Data de criação: 26/01/2020
 */
interface IBuilderErrorMessage
{
     /**
     * mount(string $bind, string $rule)
     * 
     * Monta menságem de resultado da 
     * validação de cada campo inválido
     * @param string $bind Valor da propriedade name do input
     * @param string $rule Regra a ser aplicada
     * @return string $message Menságem a ser exibida
     */
    public function build(string $bind, string $rule) : string;
}
