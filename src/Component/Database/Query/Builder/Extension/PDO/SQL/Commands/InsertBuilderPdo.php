<?php
namespace Laventure\Component\Database\Query\Builder\Extension\PDO\SQL\Commands;



use Laventure\Component\Database\Query\Builder\SQL\Commands\Insert;


/**
 *
*/
class InsertBuilderPdo extends Insert
{


    /**
     * @var int
    */
    protected $index = 1;




    /**
     * @var array
    */
    protected $bindingParameters = [];




    /**
     * @param array $attributes
     * @param string $table
    */
    public function __construct(array $attributes, string $table)
    {
          parent::__construct($attributes, $table);
    }




    /**
     * @param array $attributes
     * @return void
    */
    public function addAttribute(array $attributes)
    {
          parent::addAttribute($attributes);

          $this->bindParameters($attributes);
    }




    /**
     * @param array $attributes
     * @return void
    */
    public function bindParameters(array $attributes)
    {
        foreach ($attributes as $name => $value) {
            $name = "$name{$this->index}";
            $this->bindingParameters[$this->index][":". $name] = $value;
            $this->setParameter($name, $value);
        }

        $this->index++;
    }




    /**
     * @inheritDoc
    */
    protected function makeInsertionValues(): string
    {
          $insertions = [];

          foreach ($this->getBindingParameters() as $bindingParameters) {
              $insertions[] = "(" . implode(", ", array_keys($bindingParameters)) . ")";
          }

          return join(', ', $insertions);
    }




    /**
     * @return mixed
    */
    protected function getBindingParameters(): array
    {
         return $this->bindingParameters;
    }
}