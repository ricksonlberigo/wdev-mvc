<?php

namespace App\Http;

use App\Utils\Debug;

class Request
{
  /**
   * Instância do router
   *
   * @var Router
   */
  private Router $router;

  /**
   * Método HTTP da requisição
   *
   * @var string
   */
  private string $httpMethod;

  /**
   * URI da página
   *
   * @var string
   */
  private string $uri;

  /**
   * Parâmetros da URL
   *
   * @var array
   */
  private array $queryParams = [];

  /**
   * Variáveis que recebemos do POST da página
   *
   * @var array
   */
  private array $postVars = [];

  /**
   * Cabeçalho da requisição
   *
   * @var array
   */
  private array $headers = [];

  /**
   * Construtor da classe
   */
  public function __construct(Router $router)
  {
    $this->router = $router;
    $this->queryParams = $_GET ?? [];
    $this->postVars = $_POST ?? [];
    $this->headers = getallheaders();
    $this->httpMethod = $_SERVER["REQUEST_METHOD"] ?? "";
    $this->setUri();
  }

  /**
   * Método responsável por definir a URI
   *
   * @return 
   */
  private function setUri()
  {
    // URI COMPLETA COM GETS
    $this->uri = $_SERVER["REQUEST_URI"] ?? "";

    // REMOVE GETS DA URI
    $xUri = explode("?", $this->uri);
    $this->uri = $xUri[0];
  }

  /**
   * Método responsável por retornar a instância de Router
   *
   * @return  Router
   */
  public function getRouter(): Router
  {
    return $this->router;
  }

  /**
   * Método responsável por retornar método HTTP da requisição
   *
   * @return  string
   */
  public function getHttpMethod(): string
  {
    return $this->httpMethod;
  }

  /**
   * Método responsável por retornar a URI da requisição
   *
   * @return  string
   */
  public function getUri(): string
  {
    return $this->uri;
  }

  /**
   * Método responsável por retornar os headers da requisição
   *
   * @return  string
   */
  public function getHeaders(): array
  {
    return $this->headers;
  }


  /**
   * Método responsável por retornar os parâmetros da URL da requisição
   *
   * @return  array
   */
  public function getQueryParams(): array
  {
    return $this->queryParams;
  }

  /**
   * Método responsável por retornar as variáveis do POST da requisição
   *
   * @return  array
   */
  public function getPostVars(): array
  {
    return $this->postVars;
  }
}
