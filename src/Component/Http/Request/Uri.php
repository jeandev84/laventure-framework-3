<?php
namespace Laventure\Component\Http\Request;


use Laventure\Component\Http\Bag\ServerBag;
use Laventure\Component\Http\Request\Contract\UriInterface;



/**
 * Uri
*/
class Uri implements UriInterface
{

    /**
     * Get scheme
     *
     * @var string
     */
    protected $scheme;




    /**
     * Get host
     *
     * @var string
     */
    protected $host;





    /**
     * Get username
     *
     * @var string
     */
    protected $username;




    /**
     * Get password
     *
     * @var string
     */
    protected $password;







    /**
     * Get port
     *
     * @var string
     */
    protected $port;





    /**
     * Get path
     *
     * @var string
     */
    protected $path;





    /**
     * Query string
     *
     * @var string
     */
    protected $queryString;





    /**
     * Fragment request
     *
     * @var string
     */
    protected $fragment;



    /**
     * @param ServerBag|null $server
     */
    public function __construct(ServerBag $server = null)
    {
        if ($server) {
            $this->parse($server);
        }
    }





    /**
     * @inheritDoc
     */
    public function getScheme(): string
    {
        return $this->scheme;
    }



    /**
     * @inheritDoc
     */
    public function getAuthority(): string
    {
        return $this->password;
    }



    /**
     * @inheritDoc
     */
    public function getUserInfo(): string
    {
        return $this->username;
    }





    /**
     * @inheritDoc
     */
    public function getHost(): string
    {
        return $this->host;
    }




    /**
     * @inheritDoc
     */
    public function getPort()
    {
        return $this->port;
    }




    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        return $this->path;
    }



    /**
     * @inheritDoc
     */
    public function getQuery(): string
    {
        return $this->queryString;
    }



    /**
     * @inheritDoc
    */
    public function getFragment(): string
    {
        return $this->fragment;
    }




    /**
     * @inheritDoc
     */
    public function withScheme($scheme)
    {
        $this->scheme = $scheme;

        return $this;
    }



    /**
     * @inheritDoc
     */
    public function withUserInfo($user, $password = null)
    {
        $this->username = $user;
        $this->password = $password;

        return $this;
    }




    /**
     * @inheritDoc
     */
    public function withHost($host)
    {
        $this->host = $host;

        return $this;
    }




    /**
     * @inheritDoc
     */
    public function withPort($port)
    {
        $this->port = $port;

        return $this;
    }




    /**
     * @inheritDoc
     */
    public function withPath($path)
    {
        $this->path = $path;

        return $this;
    }





    /**
     * @inheritDoc
     */
    public function withQuery($query)
    {
        $this->queryString = $query;

        return $this;
    }





    /**
     * @inheritDoc
     */
    public function withFragment($fragment)
    {
        $this->fragment = $fragment;

        return $this;
    }




    /**
     * @inheritDoc
    */
    public function __toString()
    {
        return sprintf('%s%s%s',
               $this->path,
               $this->queryString,
               $this->fragment
        );
    }



    /**
     * @param ServerBag $server
     * @return void
    */
    protected function parse(ServerBag $server)
    {
        $this->withScheme($server->scheme())
             ->withUserInfo($server->username(), $server->password())
             ->withHost($server->host())
             ->withPort($server->port())
             ->withPath($server->pathInfo())
             ->withQuery($server->queryString())
             ->withFragment(null);
    }
}