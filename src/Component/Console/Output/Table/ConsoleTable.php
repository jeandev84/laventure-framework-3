<?php
namespace Laventure\Component\Console\Output\Table;

use Laventure\Component\Console\Output\ConsoleOutput;



/**
 * @class ConsoleTable
 *
 * @package Laventure\Component\Console\Output\Table
 *
 * @author
*/
class ConsoleTable
{

      /**
       * @var ConsoleOutput
      */
      protected $output;




      /**
       * @var string
      */
      protected $mask = "|%5.5s |%-30.30s |%-30.30s |%-30.30s |%-30.30s";





      /**
       * @var array
      */
      protected $headers = [];




      /**
       * @var array
      */
      protected $rows = [];





      /**
       * ConsoleTable constructor.
       *
       * @param ConsoleOutput $output
      */
      public function __construct(ConsoleOutput $output)
      {
           $this->output = $output;
      }






      /**
       * Set headers
       *
       * @param array $headers
       * @return void
      */
      public function setHeaders(array $headers)
      {
           $this->headers = array_merge($this->headers, $headers);
      }





      /**
       * @param array $rows
       * @return void
      */
      public function setRows(array $rows)
      {
           $this->rows = array_merge($this->rows, $rows);
      }




      public function render()
      {
          $this->renderHeaders();
          $this->renderRows();
      }




      private function renderHeaders()
      {
           printf("|%s|\n", join("|", $this->headers));
      }




      private function renderRows()
      {
         foreach ($this->rows as $rows) {
             printf("|%s|\n", join("|", $rows));
         }
      }



      /**
        * @param array $items
        * @param string $separator
        * @return void
      */
      private function print(array $items, string $separator)
      {
          $line = join($separator, $items) ."\n";

          printf($line);
      }
}