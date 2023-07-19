<?php

use App\Utils\View;
use WilliamCosta\DotEnv\Environment;
use WilliamCosta\DatabaseManager\Database;

require_once __DIR__ . "/../vendor/autoload.php";

//LOAD ENVIRONMENT VARS FROM FILE ON ROOT
Environment::load(__DIR__ . "/../");

// DEFINE AS CONFIGURAÇÕES DE BANCO DE DADOS
Database::config(
  getenv('DB_HOST'),
  getenv('DB_NAME'),
  getenv('DB_USER'),
  getenv('DB_PASS'),
);

// DEFINE A CONSTANTE DE URL DO PROJETO
define('URL', getenv('URL'));

// DEFINE O VALOR PADRÃO DAS VARIÁVEIS
View::init([
  'URL' => URL
]);
