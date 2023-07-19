<?php

namespace App\Controller\Pages;

use App\Utils\View;
use App\Http\Request;
use WilliamCosta\DatabaseManager\Pagination;
use App\Model\Entity\Testimony as EntityTestimony;
use App\Utils\Debug;

class Testimony extends Page
{
  /**
   * Método responsável por obter a renderização dos itens para a página
   *
   * @return string
   * @param Pagination $obPagination
   * @param Request $request
   */
  private static function getTestimonyItens(Request $request, &$obPagination): string
  {
    // DEPOIMENTOS
    $itens = '';

    // QUANTIDADE TOTAL DE REGISTROS
    $quantidadeTotal = EntityTestimony::getTestimonies(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

    // PÁGINA ATUAL
    $queryParams = $request->getQueryParams();
    $paginaAtual = $queryParams['page'] ?? 1;

    // INSTÂNCIA DE PAGINAÇÃO
    $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 3);

    // RESULTADOS DA PÁGINA
    $results = EntityTestimony::getTestimonies(null, 'id DESC', $obPagination->getLimit());

    // RENDERIZA O ITEM
    while ($obTestimony = $results->fetchObject(EntityTestimony::class)) {
      $itens .=  View::render("pages/testimony/item", [
        'nome' => $obTestimony->nome,
        'mensagem' => $obTestimony->mensagem,
        'data' => date('d/m/Y H:i:s', strtotime($obTestimony->data))
      ]);
    }

    // RETORNA OS DEPOIMENTOS
    return $itens;
  }

  /**
   * Método responsável de retornar o conteúdo (view) da página de depoimentos
   *
   * @return string
   * @param Request $request
   */
  public static function getTestimonies(Request $request): string
  {
    $content =  View::render("pages/testimonies", [
      'itens' => self::getTestimonyItens($request, $obPagination),
      'pagination' => parent::getPagination($request, $obPagination)
    ]);

    return parent::getPage("Depoimentos > WDev", $content);
  }

  /**
   * Método responsável por cadastrar um depoimento
   *
   * @param Request $request
   * @return string
   */
  public static function insertTestimony(Request $request): string
  { // DADOS DO POST
    $postVars = $request->getPostVars();

    // NOVA INSTÂNCIA DE DEPOIMENTO
    $obTestimony = new EntityTestimony();
    $obTestimony->nome = $postVars['nome'];
    $obTestimony->mensagem = $postVars['mensagem'];
    $obTestimony->cadastrar();

    // RETORNA A PAGINA DE LISTAGEM DE DEPOIMENTOS
    return self::getTestimonies($request);
  }
}
