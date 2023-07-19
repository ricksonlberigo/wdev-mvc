<?php

namespace App\Controller\Pages;

use App\Utils\View;
use App\Http\Request;
use App\Utils\Debug;
use WilliamCosta\DatabaseManager\Pagination;

class Page
{

  /**
   * Método responsável por renderizar o topo da página
   *
   * @return string
   */
  private static function getHeader(): string
  {
    return View::render("pages/header");
  }

  /**
   * Método responsável por renderizar o rodapé da página
   *
   * @return string
   */
  private static function getFooter(): string
  {
    return View::render("pages/footer");
  }

  /**
   * Método responsável de retornar o conteúdo (view) da página 
   *
   * @return string
   */
  public static function getPage(string $title, $content): string
  {
    return View::render("pages/page", [
      "title" => $title,
      'header' => self::getHeader(),
      "content" => $content,
      'footer' => self::getFooter(),
    ]);
  }

  /**
   * Método responsável por renderizar o layout a paginação
   *
   * @param Request $request
   * @param Pagination $obPagination
   * @return string
   */
  public static function getPagination(Request $request, Pagination $obPagination): string
  {
    // PÁGINAS
    $pages = $obPagination->getPages();

    // VERIFICA A QUANTIDADE DE PÁGINAS
    if (count($pages) <= 1) return "";

    // LINKS
    $links = '';

    // URL ATUAL SEM GET
    $url = $request->getRouter()->getCurrentUrl();

    // GET
    $queryParams = $request->getQueryParams();

    // RENDERIZA OS LINKS
    foreach ($pages as $page) {
      // ALTERA A PÁGINA
      $queryParams['page'] = $page['page'];

      // LINK
      $link = $url . '?' . http_build_query($queryParams);

      // VIEW
      $links .=  View::render("pages/pagination/link", [
        'page' => $page['page'],
        'link' => $link,
        'active' => $page['current'] ? 'active' : ''
      ]);
    }

    // RENDERIZA BOX DE PAGINAÇÃO
    return View::render("pages/pagination/box", [
      'links' => $links
    ]);
  }
}
