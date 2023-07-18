<?php

namespace App\Model\Entity;

class Organization
{
  /**
   * ID da organização
   *
   * @var integer
   */
  public int $id = 1;

  /**
   * Nome da organização
   *
   * @var string
   */
  public string $name = "Canal WDEV";

  /**
   * Site da organização
   *
   * @var string
   */
  public string $site = "https://youtube.com/wdevoficial";

  /**
   * Descrição da organização
   *
   * @var string
   */
  public string $description = "Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas ipsa commodi
  temporibus repellat, cumque minima praesentium. Voluptates, aspernatur iusto.
  Facilis fugit ab repellendus repudiandae beatae ratione culpa error nobis
  numquam.";
}
