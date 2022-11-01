<?php
namespace Laventure\Component\Auth;

use Laventure\Component\Auth\Contract\UserInterface;

class Auth
{


      /**
       * @param string $username
       * @param string $password
       * @param bool $rememberMe
       * @return UserInterface
     */
     public function attempt(string $username, string $password, bool $rememberMe = false): UserInterface
     {

     }
}