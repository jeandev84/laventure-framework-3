<?php
namespace Laventure\Component\Http\Bag;


use Laventure\Component\Http\Cookie\Cookie;



/**
 * @CookieBag
*/
class CookieBag extends ParameterBag
{


    /**
     * cookie params
     *
     * @var array
    */
    protected $params;



    /**
     * @var string
    */
    protected $domain = 'localhost';




    /**
     * @var bool
    */
    protected $httpOnly = false;




    /**
     * @var bool
    */
    protected $secure = false;





    /**
     * CookieBag constructor.
    */
    public function __construct()
    {
        parent::__construct($_COOKIE);
    }




    /**
     * @param string $domain
     * @return $this
    */
    public function withDomain(string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }




    /**
     * @param string $httpOnly
     * @return $this
    */
    public function withHttpOnly(string $httpOnly): self
    {
        $this->httpOnly = $httpOnly;

        return $this;
    }





    /**
     * @param bool $secure
     * @return $this
    */
    public function withSecure(bool $secure): self
    {
        $this->secure = $secure;

        return $this;
    }






    /**
     * @param string $key
     * @param $value
     * @param int $expires
     * @param string $path
     * @return $this
    */
    public function set($key, $value, int $expires = 3600, string $path = '/'): ParameterBag
    {
        new Cookie($key, $value, $expires, $path, $this->domain, $this->secure, $this->httpOnly);

        $_COOKIE[$key] = $value;

        return $this;
    }





    /**
     * @param string $key
     * @return void
    */
    public function remove($key)
    {
        if ($this->has($key)) {
            // time() -10(s)
            $this->set($key, '', -3600);
            parent::remove($key);
        }
    }

}