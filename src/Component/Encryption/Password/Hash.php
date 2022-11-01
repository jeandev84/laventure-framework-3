<?php
namespace Laventure\Component\Encryption\Password;

class Hash
{


      const DEFAULT = 'default';
      const BCRYPT  = 'bcrypt';


      /**
       * @var string
      */
      protected $algo;



      /**
       * @var array
      */
      protected $options = [];





      /**
       * @param $algo
       * @param array $options
      */
      public function __construct($algo = null, array $options = [])
      {
           $this->algo    = $algo ?: self::DEFAULT;
           $this->options = $options;
      }





      /**
       * Hash password
       *
       * @param string $password  | plain password from a input form.
       * @return false|string|null
      */
      public function make(string $password)
      {
           return password_hash($password, $this->algo(), $this->options);
      }



      /**
       * Determine if given password match hash password
       *
       * @param string $password | plain password from a input form
       * @param string $hash     | hash password from the database
       * @return bool
      */
      public function match(string $password, string $hash): bool
      {
          return password_verify($password, $hash);
      }




      /**
       * @return string
      */
      private function algo(): string
      {
            return [
                self::DEFAULT => PASSWORD_DEFAULT,
                self::BCRYPT  => PASSWORD_BCRYPT
            ][$this->algo];
      }
}