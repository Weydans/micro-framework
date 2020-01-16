<?php

/**
 * config.php
 * 
 * Arquivo responsável pela configuração geral do sistema
 * @author Weydans Barros
 * Data de criação: 12/01/2020
 */

/**
 * TEMPLATE
 */
const TEMPLATE_HEADER = 'header.php';
const TEMPLATE_FOOTER = 'footer.php';


/**
 * BANCO DE DADOS
 */
const SGBD = 'mysql';
const HOST = 'localhost';
const BASE = 'todo_app';
const USER = 'root';
const PASS = '';


/**
 * NAMESPACES QUE NÃO SEGUEM A HIERARQIA DE DIRETÓRIOS DO PROJETO
 */
const COUSTOM_NAMESPACES = [
    'PHPMailer' => [
        'PHPMailer\PHPMailer\PHPMailer' => 'Vendor/PHPMailer/src/PHPMailer.php',
        'PHPMailer\PHPMailer\Exception' => 'Vendor/PHPMailer/src/Exception.php',
        'PHPMailer\PHPMailer\SMTP'      => 'Vendor/PHPMailer/src/SMTP.php',
    ],
];
