<?php

use App\Http\Router;
use App\Utils\View;

define('URL', "http://localhost:8000");

require_once __DIR__ . "/vendor/autoload.php";

// DEFINE O VALOR PADRÃO DAS VARIÁVEIS
View::init([
  'URL' => URL
]);

// INICIA O ROUTER
$obRouter = new Router(URL);

// INCLUI AS ROTAS
include __DIR__ . "/routes/pages.php";

// IMPRIME O RESPONSE DA ROTA
$obRouter->run()->sendResponse();