<?php
namespace Laventure\Component\Console\Input;


class InputOption extends InputParameter
{


    /**
     * @var string
    */
    protected $shortcut;



    /**
     * @param $name
     * @param $shortcut
     * @param $description
     * @param string|null $default
     * @param array $rules
    */
    public function __construct($name, $description, $shortcut = null, $default = null, array $rules = [])
    {
           parent::__construct($name, $description, $default, $rules);
           $this->shortcut = $shortcut;
    }




    /**
     * @return string
    */
    public function getShortcut(): string
    {
        return $this->shortcut;
    }
}