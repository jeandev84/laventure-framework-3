<?php
namespace Laventure\Component\Console\Output\Style;

/**
 * @class ConsoleColors
*/
trait ConsoleColors
{

     /**
      * @var string[]
     */
     protected $foregrounds = [
         'black'       => '0;30',
         'dark_gray'   => '1;30',
         'blue'        => '0;34',
         'light_blue'  => '1;34',
         'green'       => '0;32',
         'light_green' => '1;32',
         'cyan'        => '0;36',
         'light_cyan'  => '1;36',
         'red'         => '0;31',
         'light_red'   => '1;31',
         'purple'      => '0;35',
         'light_purple'=> '1;35',
         'brown'       => '0;33',
         'yellow'      => '1;33',
         'light_gray'  => '0;37',
         'white'       => '1;37',
     ];




     /**
      * @var string[]
     */
     protected $backgrounds = [
         'black'      => '40',
         'red'        => '41',
         'green'      => '42',
         'yellow'     => '43',
         'blue'       => '44',
         'magenta'    => '45',
         'cyan'       => '46',
         'light_gray' => '47'
     ];





     /**
      * @param string $text
      * @param string $name
      * @return string
     */
     protected function foreground(string $text, string $name): string
     {
         if (! isset($this->foregrounds[$name])) {
             return "";
         }

         return "\033[". $this->foregrounds[$name] . "m{$text}\033[0m";
     }





     /**
      * @param string $text
      * @param string $name
      * @return string
     */
     protected function background(string $text, string $name): string
     {
         if (! isset($this->backgrounds[$name])) {
              return "";
         }

         return "\033[". $this->backgrounds[$name] . "m{$text}\033[0m";
     }




     /**
      * Example calls:
      *  $this->textGreen(), $this->textYellow()
      *  $this->bgGreen(), $this->bgGreen()
      *
      *
      *
      * @param $name
      * @param $arguments
      * @return string
     */
     public function __call($name, $arguments)
     {
           foreach ($this->getMethodAliases() as $alias => $method) {
                if (stripos($name, $alias) !== false) {
                    $color = strtolower(str_replace($alias, '', $name));
                    return call_user_func_array([$this, $method], [$arguments[0], $color]);
                }
           }
     }





     /**
      * @return string[]
     */
     private function getMethodAliases(): array
     {
         return [
             'bg'   => 'background',
             'text' => 'foreground'
         ];
     }
}