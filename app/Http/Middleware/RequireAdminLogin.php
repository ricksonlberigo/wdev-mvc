<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Request;
use App\Session\Admin\Login as SessionAdminLogin;

class RequireAdminLogin
{
  /**
   * Método responsável por executar o middleware
   *
   * @param Request $request
   * @param Closure next
   * @return Response
   */
  public function handle(Request $request, Closure $next)
  {
    // VERIFICA SE O USUÁRIO ESTÁ LOGADO
    if (!SessionAdminLogin::isLogged()) {
      $request->getRouter()->redirect("/admin/login");
    }

    // CONTINUA A EXECUÇÃO 
    return $next($request);
  }
}