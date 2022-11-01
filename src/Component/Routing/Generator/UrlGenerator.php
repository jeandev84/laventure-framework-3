<?php
namespace Laventure\Component\Routing\Generator;

use Laventure\Component\Routing\RouterInterface;


/**
 * @UrlGenerator
 */
class UrlGenerator implements UrlGeneratorInterface
{


    /**
     * @var RouterInterface
    */
    protected $router;




    /**
     * @var string
    */
    protected $networkDomain;




    /**
     * @param RouterInterface $router
     * @param $networkDomain
    */
    public function __construct(RouterInterface $router, $networkDomain)
    {
          $this->router        = $router;
          $this->networkDomain = $networkDomain;
    }




    /**
     * @inheritDoc
    */
    public function generate(string $name, array $parameters = [], int $referenceType = self::ABSOLUTE_URL)
    {
        if ($path = $this->router->generate($name, $parameters)) {
            return $this->generatePath($path, [], $referenceType);
        }

        return $this->generatePath($name, $parameters, $referenceType);
    }




    /**
     * @param string $path
     * @param array $parameters
     * @param int $referenceType
     * @return string
    */
    public function generatePath(string $path, array $parameters = [], int $referenceType = self::ABSOLUTE_URL): string
    {
        return [
            self::ABSOLUTE_URL  => $this->absoluteURL($path, $parameters),
            self::ABSOLUTE_PATH => $this->absolutePath($path),
            self::RELATIVE_PATH => $this->relativePath($path),
            self::NETWORK_PATH  => $this->networkDomain()
        ][$referenceType];
    }




    /**
     * @param string $path
     * @param array $parameters
     * @return string
    */
    public function absoluteURL(string $path, array $parameters = []): string
    {
         $qs = $parameters ? '?'. http_build_query($parameters) : '';

         return sprintf('%s%s', $this->generatePath($path), $qs);
    }




    /**
     * @param string $path
     * @return string
    */
    public function absolutePath(string $path): string
    {
         return sprintf('%s%s', $this->networkDomain(), $this->relativePath($path));
    }




    /**
     * @param string $path
     * @return string
    */
    public function relativePath(string $path): string
    {
         return sprintf('/%s', trim($path, '\\/'));
    }




    /**
     * @return string
    */
    public function networkDomain(): string
    {
         return rtrim($this->networkDomain, '\\/');
    }
}