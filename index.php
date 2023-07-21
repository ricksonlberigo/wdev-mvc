<?php

use App\Http\Router;

require_once __DIR__ . "/includes/app.php";

// INICIA O ROUTER
$obRouter = new Router(URL);

// INCLUI AS ROTAS
include __DIR__ . "/routes/pages.php";

// INCLUI AS ROTAS DO PAINEL
include __DIR__ . "/routes/admin.php";

// IMPRIME O RESPONSE DA ROTA
$obRouter->run()->sendResponse();
