<?php

/**
 * Resolve problema de CORS
 * Atenção para a configuração: header('Access-Control-Allow-Origin: *');
 * substrituir * por endereços de IP liberados
 */
// header('Access-Control-Allow-Origin: *');
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
// header("Access-Control-Allow-Headers: Content-Type, Accept, Access-Control-Allow-Headers, X-Requested-With");

require_once('./bootstrap.php');
require_once('./routes.php');
