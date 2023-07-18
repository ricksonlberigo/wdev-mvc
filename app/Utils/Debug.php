<?php

namespace App\Utils;

class Debug
{
  /**
   * Método auxiliador que gera um debug para entendermos o código ou encontrar possíveis erros
   *
   * @param mixed $bug
   * @return void
   */
  public static function debugger(mixed $bug): void
  {
    echo "<pre>";
    print_r($bug);
    echo "</pre>";
  }
}