<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Request;
use Exception;

class Maintenance
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
    if (getenv('MAINTENANCE') == 'true') {
      // VERIFICA O ESTADO DE MANUTENÇÃO DA PÁGINA
      throw new Exception("Página em manutenção, tente novamente mais tarde", 200);
    }

    // EXECUTA O PRÓXIMO NÍVEL DO MIDDLEWARE
    return $next($request);
  }
}
