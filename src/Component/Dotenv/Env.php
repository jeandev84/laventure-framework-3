<?php
namespace Laventure\Component\Dotenv;


/**
 * Env
*/
class Env
{

    /**
     * @param array $environs
     * @return void
    */
    public function load(array $environs)
    {
         foreach ($environs as $environ) {
             $this->put($environ);
         }
    }



    /**
     * @param string $environ
     * @return void
    */
    public function put(string $environ)
    {
          if ($environ = $this->match($environ)) {

             list($key, $value) = explode("=", $environ, 2);

             $value = $this->filteredValue($value);

             putenv(sprintf('%s=%s', $key, $value));

             $_SERVER[$key] = $value;
             $_ENV[$key] = $value;
         }
    }



    /**
     * @param string $name
     * @return mixed
    */
    public function read(string $name)
    {
         if (isset($_SERVER[$name])) {
              return $_SERVER[$name];
         }

         if (isset($_ENV[$name])) {
              return $_ENV[$name];
         }

         return getenv($name);
    }




    /**
     * @param string $environ
     * @return array|false|string|string[]
    */
    public function match(string $environ)
    {
         if(preg_match('#^(?=[A-Z])(.*)=(.*)$#', $environ, $matches)) {
             return str_replace(' ', '', trim($matches[0]));
         }

         return false;
    }




    /**
     * @param $value
     * @return mixed|string
    */
    protected function filteredValue($value)
    {
        $value = trim($value);

        if (stripos($value, '#') !== false) {
            $value = explode('#', $value, 2)[0];
        }

        return $value;
    }
}