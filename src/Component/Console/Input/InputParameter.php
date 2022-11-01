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
    protected $shortcut;



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
     * @param string $name
     * @param $description
     * @param string|null $default
     * @param array $rules
    */
    public function __construct(string $name, $description, string $default = null, array $rules = [])
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
         return in_array(self::REQUIRED, $this->rules);
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