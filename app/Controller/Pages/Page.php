<?php

namespace App\Controller\Pages;

use App\Utils\View;

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
}
