<?php

namespace App\Controller\Pages;

use App\Utils\View;
use App\Model\Entity\Organization;

class Home extends Page
{
  /**
   * Método responsável de retornar o conteúdo (view) da página Home
   *
   * @return string
   */
  public static function getHome(): string
  {
    $obOrganization = new Organization();
    $content =  View::render("pages/home", [
      "name" => $obOrganization->name,
    ]);

    return parent::getPage("Home > WDEV", $content);
  }
}