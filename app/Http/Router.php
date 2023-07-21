<?php

namespace App\Http;

use App\Http\Middleware\Queue;
use App\Utils\Debug;
use Closure;
use Exception;
use ReflectionFunction;

class Router
{
  /**
   * URL completa do projeto
   *
   * @var string
   */
  private string $url = '';

  /**
   * Prefixo de todas as rotas
   *
   * @var string
   */
  private $prefix = '';

  /**
   * Indices de rotas
   *
   * @var array
   */
  private array $routes = [];

  /**
   * Instância de Request
   *
   * @var Request
   */
  private Request $request;

  /**
   * Método responsável por iniciar a classe
   *
   * @param string $url
   */
  public function __construct(string $url)
  {
    $this->request = new Request($this);
    $this->url = $url;
    $this->setPrefix();
  }

  /**
   * Método responsável por definir o prefixo das rotas
   *
   * @return void
   */
  private function setPrefix(): void
  {
    // INFORMAÇÕES DA URL ATUAL
    $parseUrl = parse_url($this->url);

    // DEFINE O PREFIXO
    $this->prefix = $parseUrl["path"] ?? "";
  }

  /**
   * Método responsável por adicionar uma rota na classe
   *
   * @param string $method
   * @param string $route
   * @param array $params
   * @return void
   */
  private function addRoute(string $method, string $route, array $params = [])
  {
    // VALIDAÇÃO DOS PARÂMETROS
    foreach ($params as $key => $value) {
      if ($value instanceof Closure) {
        $params["controller"] = $value;
        unset($params[$key]);
        continue;
      }
    }

    // MIDDLEWARES DA ROTA
    $params['middlewares'] = $params['middlewares'] ?? [];

    // VARIÁVEIS DA ROTA
    $params['variables'] = [];

    // PADRÃO DE VALIDAÇÃO DAS ROTAS
    $patternVariable = '/{(.*?)}/';
    if (preg_match_all($patternVariable, $route, $matches)) {
      $route = preg_replace($patternVariable, '(.*?)', $route);
      $params['variables'] = $matches[1];
    }

    // PADRÃO DE VALIDÃO DA URL
    $patterRoute = '/^' . str_replace('/', '\/', $route) . '$/';

    // ADICIONA A ROTA DENTRO DA CLASSE
    $this->routes[$patterRoute][$method] = $params;
  }


  /**
   * Método responsável por definir uma rota de GET
   *
   * @param string $route
   * @param array $params
   * @return 
   */
  public function get(string $route, $params = [])
  {
    return $this->addRoute('GET', $route, $params);
  }

  /**
   * Método responsável por definir uma rota de POST
   *
   * @param string $route
   * @param array $params
   * @return 
   */
  public function post(string $route, $params = [])
  {
    return $this->addRoute('POST', $route, $params);
  }

  /**
   * Método responsável por definir uma rota de PUT
   * @param string $route
   * @param array $params
   * @return 
   */
  public function put(string $route, $params = [])
  {
    return $this->addRoute('PUT', $route, $params);
  }

  /**
   * Método responsável por definir uma rota de DELETE
   * @param string $route
   * @param array $params
   * @return 
   */
  public function delete(string $route, $params = [])
  {
    return $this->addRoute('DELETE', $route, $params);
  }

  /**
   * Método responsável por retornar a URI desconsiderando o prefixo
   *
   * @return string
   */
  private function getUri(): string
  {
    // URI DA REQUEST
    $uri = $this->request->getUri();

    $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

    // RETORNA A URI SEM PREFIXO
    return end($xUri);
  }

  /**
   * Método responsável por retornar os da rota atual
   *
   * @return array
   */
  private function getRoute()
  {
    //URI
    $uri = $this->getUri();

    // METHOD
    $httpMethod = $this->request->getHttpMethod();

    // VALIDA AS ROTAS
    foreach ($this->routes as $patternRoute => $methods) {
      // VERIFICA SE A URI BATE COM O PADRÃO
      if (preg_match($patternRoute, $uri, $matches)) {
        // VERIFICA O MÉTODO
        if (isset($methods[$httpMethod])) {
          // REMOVE A PRIMEIRA POSIÇÃO
          unset($matches[0]);

          // VARIÁVEIS PROCESSADAS
          $keys = $methods[$httpMethod]['variables'];
          $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
          $methods[$httpMethod]['variables']['request'] = $this->request;

          // RETORNO DOS PARÂMETROS DA ROTA
          return $methods[$httpMethod];
        }

        // MÉTODO NÃO PERMITIDO
        throw new Exception("Método não permitido", 405);
      }
    }

    // URL NÃO ENCONTRADA
    throw new Exception("URL não encontrada", 404);
  }

  /**
   * Método responsável por retornar a rota atual
   *
   * @return Response
   */
  public function run(): Response
  {
    try {
      // OBTÉM A ROTA ATUAL
      $route = $this->getRoute();

      if (!isset($route['controller'])) {
        throw new Exception("URL não pode ser processada", 500);
      }

      // ARGUMENTOS DA FUNÇÃO
      $args = [];

      // REFLECTION
      $reflection = new ReflectionFunction($route['controller']);
      foreach ($reflection->getParameters() as $parameter) {
        $name = $parameter->getName();
        $args[$name] = $route['variables'][$name] ?? "";
      }

      // RETORNA A EXECUÇÃO DA FILA DE MIDDLEWARES
      return (new Queue($route["middlewares"], $route["controller"], $args))->next($this->request);
      exit;
    } catch (Exception $e) {
      return new Response($e->getCode(), $e->getMessage());
    }
  }

  /**
   * Método responsável por retornar a URL atual
   *
   * @return string
   */
  public function getCurrentUrl(): string
  {
    return $this->url . $this->getUri();
  }

  /**
   * Método responsável por redirecionar a URL
   *
   * @param string $route
   * @return void
   */
  public function redirect($route)
  {
    // URL
    $url = $this->url . $route;

    // EXECUTA O REDIRECT
    header('location: ' . $url);
    exit;
  }
}
