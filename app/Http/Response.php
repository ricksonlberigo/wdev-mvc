<?php

namespace App\Http;

class Response
{
  /**
   * Código do Status HTTP
   *
   * @var integer
   */
  private int $httpCode = 200;

  /**
   * Cabeçalho do response
   *
   * @var array
   */
  private array $headers = [];

  /**
   * Tipo de conteúdo que está sendo retornado
   *
   * @var string
   */
  private string $contentType = "text/html";

  /**
   * Conteúdo do response
   *
   * @var mixed
   */
  private mixed $content;

  /**
   * Método responsável por inicializar a classe e definir seus valores
   *
   * @param integer $httpCode
   * @param mixed $content
   * @param string $contentType
   */
  public function __construct(int $httpCode, mixed $content, $contentType = "text/html")
  {
    $this->httpCode = $httpCode;
    $this->content = $content;
    $this->setContentType($contentType);
  }

  /**
   * Método responsável por alterar o content type do nosso response
   *
   * @param string $contentType
   * @return void
   */
  public function setContentType(string $contentType): void
  {
    $this->contentType = $contentType;
    $this->addHeader('Content-Type', $contentType);
  }

  /**
   * Método responsável por adicionar um registro no cabeçalho de response
   *
   * @param string $key
   * @param string $value
   * @return void
   */
  public function addHeader($key, $value): void
  {
    $this->headers[$key] = $value;
  }

  /**
   * Método responsável por enviar os headers para o navegador
   *
   * @return void
   */
  private function sendHeaders(): void
  {
    // STATUS
    http_response_code($this->httpCode);

    // ENVIAR HEADERS
    foreach ($this->headers as $key => $value) {
      header($key . ': ' . $value);
    }
  }

  /**
   * Método responsável por enviar a resposta para o usuário
   *
   * @return void
   */
  public function sendResponse()
  {
    // ENVIA OS HEADERS
    $this->sendHeaders();

    // RETORNA O CONTEÚDO
    switch ($this->contentType) {
      case 'text/html':
        echo $this->content;
        exit;
    }
  }
}
