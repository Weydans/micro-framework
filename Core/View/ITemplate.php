<?php

namespace Core\View;

/**
 * ITemplate
 * 
 * Responsável por fornecer interface 
 * comum a todas as classes de template do sistema
 * @author Weydans Barros
 * Data de criação: 12/01/2020
 */

interface ITemplate
{
    public function getHeader() : string;
    public function getFooter() : string;
    public function getContent() : string;

    public function setHeader(string $header);
    public function setFooter(string $footer);
    public function setContent(string $content);
    
    public function view(string $view, array $dados);
}
