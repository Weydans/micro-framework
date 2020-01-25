<?php

namespace Core;

use \Exception;

/**
 * Autoload
 * 
 * Responsável pelo carregamento de classes do sistema seguindo a PSR4
 * @author Weydans Barros
 * Data de criação 29/12/2019
 */

abstract class Autoload
{
    public static function run() 
    {
        spl_autoload_register(function($class) {

            $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
            $res = false;
            
            // CARREGA CLASSES DO PROJETO 
            // SEGUINDO HIERARQUIA DE DIRETÓRIOS
            if (file_exists($file) && !is_dir($file)) {
                require_once($file);
                $res = $file;
                return;

            // CARREGA CLASSES DO PROJETO COM NAMESPACES 
            // PERSONALIZADOS QUE NÃO SEGUEM A HIERARQUIA DE DIRETÓRIOS
            } elseif (!file_exists($file)) {
                foreach (COUSTOM_NAMESPACES as $files) {
                    if (array_key_exists($class, $files)) {
                        require_once($files[$class]);
                        $res = $file;
                        return;
                    }
                }
            }

            if (!$res) {
                throw new Exception("Class not found '{$file}'");
            }
        });
    }
}
