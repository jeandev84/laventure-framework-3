<?php
namespace Laventure\Component\Console\Input;



/**
 * ConsoleInputArgv
*/
class ConsoleInputArgv extends InputArgv
{


    /**
     * @inheritdoc
    */
    public function __construct(array $tokens = [])
    {
        /*
         if (! $tokens) {
            $tokens = $_SERVER['argv'];
         }
        */

        parent::__construct($tokens ?: $_SERVER['argv']);
    }



    /**
     * @return int
    */
    public function count(): int
    {
        return $_SERVER['argc'] ?? 0;
    }







    /**
     * @inheritDoc
    */
    public function parseTokens($tokens)
    {
         foreach ($tokens as $token) {
             $this->parsedToken($token);
         }
    }





    /**
     * @param $token
     * @return void
    */
    private function parsedToken($token)
    {
         if (preg_match("/^(.+)=(.+)$/", $token)) {
             if ($options = $this->matchOption($token)) {
                 $this->setOption($options[1], $options[2]);
             } else{
                 list($name, $value) = explode('=', $token, 2);
                 $this->setArgument($name, $value);
             }
         }elseif($flags = $this->matchFlag($token)) {
             $this->setOption($flags[1], $flags[1]);
         }else{
             $this->addArgument($token);
         }
    }



    /**
     * @param $token
     * @return mixed
    */
    private function matchOption($token)
    {
        preg_match('#^--([^=]+)=(.*)$#i', $token,$options) ||
        preg_match('#^-([^=]+)=(.*)$#i', $token,$options);

        return $options;
    }






    /**
     * @param $token
     * @return mixed
    */
    private function matchFlag($token)
    {
        preg_match('#^--([^=]+)$#i', $token,$flags) ||
        preg_match('#^-([^=]+)$#i', $token,$flags);

        return $flags;
    }
}