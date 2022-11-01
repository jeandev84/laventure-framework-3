<?php
namespace Laventure\Component\Database\Schema\BluePrint\Column;

/**
 * Column
*/
class Column
{
    /**
     * @var array
    */
    protected $items = [
        'name'          => '',
        'type'          => '',
        'primaryKey'    => false,
        'default'       => 'NOT NULL',
        'collation'     => '',
        'comments'      => ''
    ];



    /**
     * @param $name
     * @param $value
     * @return $this
    */
    public function with($name, $value): self
    {
         $this->items[$name] = $value;

         return $this;
    }



    /**
     * Remove column item
     *
     * @param $name
     * @return void
    */
    public function remove($name)
    {
         unset($this->items[$name]);
    }




    /**
     * @param array $items
     * @return $this
    */
    public function withItems(array $items): self
    {
         $this->items = array_merge($this->items, $items);

         return $this;
    }




    /**
     * @param $name
     * @return $this
    */
    public function name($name): self
    {
         return $this->with('name', $name);
    }




    /**
     * @param $type
     * @param null $length
     * @return $this
    */
    public function type($type, $length = null): self
    {
         $type = $length ? sprintf('%s(%s)', strtoupper($type), $length) : $type;

         return $this->with('type', $type);
    }




    /**
     * @return string
    */
    public function getName(): string
    {
         return $this->items['name'];
    }




    /**
     * @return $this
    */
    public function primaryKey(): self
    {
          return $this->with('primaryKey', 'PRIMARY KEY');
    }



    /**
     * @return $this
    */
    public function unique(): self
    {
         return $this->with('unique', 'UNIQUE');
    }




    /**
     * @return $this
    */
    public function unsigned(): self
    {
         if ($this->items['type']) {
              $this->items['type'] .= " UNSIGNED";
         }

         return $this;
    }




    /**
     * @return $this
    */
    public function signed(): self
    {
        if ($this->items['type']) {
            $this->items['type'] .= " SIGNED";
        }

        return $this;
    }





    /**
     * @param string $name
     * @return Column
    */
    public function extra(string $name = 'AUTO_INCREMENT'): Column
    {
         return $this->with('extra', $name);
    }



    /**
     * @param string $column
     * @return $this
    */
    public function after(string $column): self
    {
         return $this->with('position', "AFTER {$column}");
    }




    /**
     * @param string $column
     * @return $this
    */
    public function before(string $column): self
    {
        return $this->with('position', "BEFORE {$column}");
    }





    /**
     * Set nullable column
     *
     * @return $this
    */
    public function nullable(): self
    {
         return $this->with('default', 'DEFAULT NULL');
    }




    /**
     * @param $value
     * @return $this
    */
    public function default($value): self
    {
         return $this->with('default', sprintf('DEFAULT "%s" NOT NULL', $value));
    }




    /**
     * @return string
    */
    public function __toString()
    {
         $items = array_filter(array_values($this->items));

         return implode(' ', $items);
    }
}