<?php

namespace Core\View;

use Core\View\ITemplate;

/**
 * Template
 * 
 * Responsável pela configuração do template principal do sistema
 * @author Weydans Barros
 * Data de criação: 12/01/2020
 */
class Template implements ITemplate
{
    protected $header;
    protected $footer;
    protected $content;

    const BASE_VIEW = '.' . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'View' . DIRECTORY_SEPARATOR;


    public function __construct()
    {
        $this->header = self::BASE_VIEW . TEMPLATE_HEADER;
        $this->footer = self::BASE_VIEW . TEMPLATE_FOOTER;
        $this->content = '';
    }


    public function getHeader() : string
    {
        return $this->header;
    }


    public function getFooter() : string
    {
        return $this->footer;
    }


    public function getContent() : string
    {
        return $this->content;
    }


    public function setHeader(string $header)
    {
        if (!empty($header)) {
            $this->header = self::BASE_VIEW . $header;
            return;
        }

        $this->header = $header;
    }


    public function setFooter(string $footer)
    {
        if (!empty($footer)) {
            $this->footer = self::BASE_VIEW . $footer;
            return;
        }

        $this->footer = $footer;
    }


    public function setContent(string $content)
    {
        $file = self::BASE_VIEW . $content;

        if (file_exists($file) && !is_dir($file)) {
            $this->content = $file;
        }
    }


    public function view(string $view, array $dados = [])
    {
        $this->setContent($view);

        if (count($dados) > 0) {
            extract($dados);
        }

        if (!empty($this->header)) {
            require_once($this->header);
        }

        if (!empty($this->content)) {
            require_once($this->content);
        }
        
        if (!empty($this->footer)) {
            require_once($this->footer);
        }
    }
}
