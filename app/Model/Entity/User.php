<?php

namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class User
{
  /**
   * ID do usuário
   *
   * @var integer
   */
  public int $id;

  /**
   * Nome do usuário
   *
   * @var string
   */
  public string $nome;

  /**
   * E-mail do usuário
   *
   * @var string
   */
  public string $email;

  /**
   * Senha do usuário
   *
   * @var string
   */
  public string $senha;

  /**
   * Método responsável por retornar um usuário com base em seu e-mail
   *
   * @param string $email
   * @return User|null
   */
  public static function getUserByEmail(string $email): ?User
  {
    $user = (new Database('usuarios'))->select('email = "' . $email . '"')->fetchObject(self::class);

    // Verifica se encontrou algum usuário com o e-mail fornecido
    if ($user instanceof User) {
      return $user;
    }

    return null;
  }
}
