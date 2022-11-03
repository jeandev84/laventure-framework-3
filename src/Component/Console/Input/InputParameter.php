<?php
namespace Laventure\Component\Console\Input;


/**
 * InputParameter
*/
abstract class InputParameter
{

    const REQUIRED  =  1;
    const OPTIONAL  =  2;


    /**
     * @var string
    */
    protected $name;




    /**
     * @var string
    */
    protected $description;



    /**
     * @var string
    */
    protected $default;




    /**
     * @var array
    */
    protected $rules = [];




    /**
     * @var array
    */
    protected $options = [];






    /**
     * InputArgument constructor.
     *
     * @param $name
     * @param $description
     * @param $default
     * @param array $rules
    */
    public function __construct($name, $description, $default = null, array $rules = [])
    {
          $this->name         = $name;
          $this->description  = $description;
          $this->default      = $default;
          $this->rules        = $rules;
    }




    /**
     * @return bool
    */
    public function isRequired(): bool
    {
         return in_array(static::REQUIRED, $this->rules);
    }



    /**
     * @return bool
    */
    public function isOptional(): bool
    {
         return in_array(static::OPTIONAL, $this->rules);
    }




    /**
     * @return array
    */
    public function getRules(): array
    {
         return $this->rules;
    }






    /**
     * @return string
    */
    public function getName(): string
    {
        return $this->name;
    }




    /**
     * @return string
    */
    public function getDescription(): string
    {
         return $this->description;
    }



    /**
     * @return string
    */
    public function getShortcut(): string
    {
         return $this->shortcut;
    }




    /**
     * @return string|null
    */
    public function getDefault(): ?string
    {
         return $this->default;
    }
}