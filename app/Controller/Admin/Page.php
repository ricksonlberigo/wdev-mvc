<?php

namespace App\Controller\Admin;

use App\Utils\View;

class Page
{
  /**
   * Método responsável por retornar o conteúdo (view) da estrutura genérica da página do painel
   *
   * @param string $title
   * @param string $content
   * @return string
   */
  public static function getPage(string $title, string $content): string
  {
    return View::render('admin/page', [
      'title' => $title,
      'content' => $content
    ]);
  }
}
