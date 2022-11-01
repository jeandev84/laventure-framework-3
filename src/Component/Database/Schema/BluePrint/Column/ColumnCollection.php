<?php
namespace Laventure\Component\Database\Schema\BluePrint\Column;

/**
 * ColumnCollection
*/
class ColumnCollection
{

      /**
       * @var Column[]
      */
      protected $columns = [];




      /**
       * @var Column[]
      */
      protected $modify = [];




      /**
       * @var Column[]
      */
      protected $drop = [];



      /**
       * @var string
      */
      protected $formatColumn = '{column}';



      /**
       * @param string $name
       * @param Column $column
       * @return Column
      */
      public function addColumn(string $name, Column $column): Column
      {
           $this->columns[$name] = $column;

           return $column;
      }




      /**
       * Determine if the given name isset.
       *
       * @param string $name
       * @return bool
      */
      public function hasColumn(string $name): bool
      {
           return isset($this->columns[$name]);
      }




      /**
       * Get column
       *
       * @param string $name
       * @return Column|null
      */
      public function getColumn(string $name): ?Column
      {
           return $this->columns[$name] ?? null;
      }





      /**
       * Remove column
       *
       * @param string $name
       * @return void
      */
      public function removeColumn(string $name)
      {
            unset($this->columns[$name]);
      }




      /**
       * @return Column[]
      */
      public function getColumns(): array
      {
           return $this->columns;
      }



      /**
       * @param string[] $tableColumns
       * @return Column[]
      */
      public function diff(array $tableColumns): array
      {
            $newColumns = [];

            foreach ($this->getColumns() as $name => $column) {
              if (! in_array($name, $tableColumns)) {
                  $newColumns[] = $this->getColumn($name);
              }
            }

            return $newColumns;
      }


      /**
       * @param $name
       * @param Column $column
       * @return void
      */
      protected function prepareColumn($name, Column $column)
      {
            $name = preg_replace('#{column}#', $name, $this->formatColumn);

            $column->name($name);

            return $column;
      }



      /**
       * @return string
      */
      public function __toString()
      {
           return join(", \n", array_values($this->columns));
      }
}