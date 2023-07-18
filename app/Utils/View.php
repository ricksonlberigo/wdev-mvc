<?php

namespace App\Utils;

class View
{
  /**
   * Método responsável por retornar o conteúdo de uma view 
   * @param string $view
   * @return string
   */
  public static function getContentView(string $view): string
  {
    $file = __DIR__ . "/../../resources/view/" . $view . ".html";
    return file_exists($file) ? file_get_contents($file) : "";
  }

  /**
   * Método responsável por retornar o conteúdo da view renderizado
   * @param string $view
   * @param array $vars (string/numeric)
   * @return string
   */
  public static function render(string $view, $vars = []): string
  {
    // CONTEÚDO DA VIEW
    $contentView = self::getContentView($view);

    // CHAVES DO ARRAY DE VARIÁVEIS
    $keys = array_keys($vars);
    $keys = array_map(function ($item) {
      return "{{" . $item . "}}";
    }, $keys);

    // RETORNA O CONTEÚDO RENDERIZADO
    return str_replace($keys, array_values($vars), $contentView);
  }
}
