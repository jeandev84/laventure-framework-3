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


         //echo __METHOD__."\n";
//         dd([
//            "firstArgument" => $this->firstArgument,
//            "arguments" => $this->arguments,
//            "options"   => $this->options,
//            "shortcuts" => $this->shortcuts,
//            "flags"     => $this->flags
//         ]);
    }





    /**
     * @param $token
     * @return void
    */
    private function parsedToken($token)
    {
         preg_match("/^(.+)=(.+)$/", $token, $matches);

         if (! empty($matches)) {

             if (preg_match('#^--([^=]+)=(.*)$#i', $token,$params)) {
                 $this->setOption($params[1], $params[2]);
             }elseif(preg_match('#^-([^=]+)=(.*)$#i', $token,$params)) {
                 $this->setOption($params[1], $params[2]);
             } else {
                 list($tokenName, $tokenValue) = explode('=', $token, 2);
                 $this->setArgument($tokenName, $tokenValue);
             }

         } else {

             if (preg_match('#^--([^=]+)$#i', $token,$params)) {
                 $this->setFlag($params[1], true);
             } elseif (preg_match('#^-([^=]+)$#i', $token,$params)) {
                 $this->setFlag($params[1], true);
             }else {
                 $this->addArguments($token);
             }
         }
    }
}