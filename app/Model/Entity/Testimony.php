<?php

namespace App\Model\Entity;

use PDOStatement;
use WilliamCosta\DatabaseManager\Database;

class Testimony
{
  /**
   * ID do depoimento
   *
   * @var integer
   */
  public int $id;

  /**
   * Nome do usuário que fez o depoimento
   *
   * @var string
   */
  public string $nome;

  /**
   * Mensagem do depoimento
   *
   * @var string
   */
  public string $mensagem;

  /**
   * Data de publicação do depoimento
   *
   * @var string
   */
  public string $data;

  /**
   * Método responsável por cadastrar a instância da classe dentro do banco dae dados
   *
   * @return boolean
   */
  public function cadastrar(): bool
  {
    // Cria um objeto DateTime com a data e hora atual no fuso horário UTC
    $dataAtual = new \DateTime('now', new \DateTimeZone('UTC'));

    // Define o fuso horário de São Paulo
    $fusoSaoPaulo = new \DateTimeZone('America/Sao_Paulo');

    // Converte a data e hora para o fuso horário de São Paulo
    $dataAtual->setTimezone($fusoSaoPaulo);

    // Formata a data e hora no formato desejado (Y-m-d H:i:s)
    $this->data = $dataAtual->format('Y-m-d H:i:s');

    // INSERTE O DEPOIMENTO NO BANCO DE DADOS
    $this->id = (new Database('depoimentos'))->insert([
      'nome' => $this->nome,
      'mensagem' => $this->mensagem,
      'data' => $this->data,
    ]);

    // SUCESSO
    return true;
  }

  /**
   * Método responsável por retornar depoimentos
   *
   * @return PDOStatement
   * @param string $where
   * @param string $order
   * @param string $limit
   * @param string $fields
   */
  public static function getTestimonies(string $where = null, string $order = null, string $limit = null, string $fields = "*")
  {
    return (new Database('depoimentos'))->select($where, $order, $limit, $fields);
  }
}
