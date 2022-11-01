<?php
namespace Laventure\Component\Database\Schema\BluePrint\Keys;


/**
 * ForeignKey
*/
class ForeignKey
{

       /**
        * @var string[]
       */
       protected $items = [
           'key'         => '',
           'references'  => '',
           'on'          => '',
           'constrained' => null
       ];



       /**
        * @var string
       */
       protected $table;




       /**
        * @param string $key
        * @param string $table
       */
       public function __construct(string $key, string $table)
       {
              $this->items['key'] = $key;
              $this->table        = $table;
       }



       /**
        * @return Constrained
       */
       public function constrained(): Constrained
       {
           return $this->items['constrained'] = new Constrained();
       }



       /**
        * References table
        *
        * @param string $column
        * @return $this
       */
       public function references(string $column): self
       {
            $this->items['references'] = $column;

            return $this;
       }




      /**
       * @param $table
       * @return Constrained
       */
       public function on($table): Constrained
       {
           $this->items['on'] = $table;

           return $this->constrained();
       }




       /**
        * @return string
       */
       public function __toString()
       {
            $constraint = sprintf('fk_%s_%s', $this->table, $this->items['key']);

            $format= sprintf('CONSTRAINT %s FOREIGN KEY (%s) REFERENCES %s(%s)',
                 $constraint,
                 $this->items['key'],
                 $this->items['on'],
                 $this->items['references']
            );

            if ($this->items['constrained']) {
                 // ON DELETE (CASCADE | SET NULL | RESTRICT ...)
                //  ON UPDATE (CASCADE | SET NULL | RESTRICT ...)
                 $format .= ' '. $this->items['constrained'];
            }

            return $format . "\n";
       }

}