<?php

use App\Http\Response;
use App\Controller\Admin;
use App\Utils\Debug;

require_once __DIR__ . "/../vendor/autoload.php";

// ROTA ADMIN
$obRouter->get('/admin', [
  'middlewares' => [
    'require-admin-login'
  ],
  function () {
    return new Response(200, "Admin :)");
  }
]);

// ROTA DE LOGIN
$obRouter->get('/admin/login', [
  'middlewares' => [
    'require-admin-logout'
  ],
  function ($request) {
    return new Response(200, Admin\Login::getLogin($request));
  }
]);

// ROTA DE LOGIN (POST)
$obRouter->post('/admin/login', [
  'middlewares' => [
    'require-admin-logout'
  ],
  function ($request) {
    return new Response(200, Admin\Login::setLogin($request));
  }
]);

// ROTA DE LOGOUT
$obRouter->get('/admin/logout', [
  'middlewares' => [
    'require-admin-login'
  ],
  function ($request) {
    return new Response(200, Admin\Login::setLogout($request));
  }
]);
