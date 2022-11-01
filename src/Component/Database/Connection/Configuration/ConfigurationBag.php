<?php
namespace Laventure\Component\Database\Connection\Configuration;



/**
 * ConfigurationBag class
 */
class ConfigurationBag implements \ArrayAccess, ConfigurationBagInterface
{

    /**
     * @var array
     */
    protected $parameters = [];


    /**
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }



    /**
     * @param string $name
     * @param $value
     * @return $this
     */
    public function with(string $name, $value): self
    {
        $this->parameters[$name] = $value;

        return $this;
    }



    /**
     * @param array $params
     * @return $this
     */
    public function merge(array $params): self
    {
        $this->parameters = array_merge($this->parameters, $params);

        return $this;
    }


    /**
     * @param string $name
     * @param $default
     * @return mixed|null
     */
    public function get(string $name, $default = null)
    {
        return $this->parameters[$name] ?? $default;
    }




    /**
     * @return array
     */
    public function all(): array
    {
        return $this->parameters;
    }



    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return isset($this->parameters[$name]);
    }




    /**
     * @param string $name
     * @return void
     */
    public function remove(string $name)
    {
        unset($this->parameters[$name]);
    }



    /**
     * @return mixed|null
     */
    public function getHostname()
    {
        return $this->get('host');
    }



    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->get('username');
    }



    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->get('password');
    }



    /**
     * @return mixed
     */
    public function getDatabase()
    {
        return $this->get('database');
    }




    /**
     * @return mixed
     */
    public function getPrefix()
    {
        return $this->get('prefix');
    }



    /**
     * @param $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }



    /**
     * @param $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }


    /**
     * @param $offset
     * @param $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->with($offset, $value);
    }



    /**
     * @param $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }
}