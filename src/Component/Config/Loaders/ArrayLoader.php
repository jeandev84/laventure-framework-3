<?php
namespace Laventure\Component\Config\Loaders;


use Exception;
use Laventure\Component\Config\Contract\Loader;



/**
 * @ArrayLoader
 */
class ArrayLoader implements Loader
{

    /**
     * @var array
    */
    protected $configs;


    /**
     * ArrayLoader constructor.
     * @param array $configs
    */
    public function __construct(array $configs)
    {
        $this->configs = $configs;
    }


    /**
     * Parse method
     *
     * @return array
     * @throws Exception
    */
    public function parse(): array
    {
        $parsed = [];

        foreach ($this->configs as $name => $config) {
            $parsed[$name] = $config;
        }

        return $parsed;
    }
}