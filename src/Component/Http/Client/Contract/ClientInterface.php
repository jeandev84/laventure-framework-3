<?php
namespace Laventure\Component\Http\Client\Contract;

use Laventure\Component\Http\Response\Contract\ResponseInterface;
use Laventure\Component\Http\Request\Contract\RequestInterface;


/**
 * @ClientInterface
 */
interface ClientInterface
{
    /**
     * Sends a PSR-7 request and returns a PSR-7 response.
     *
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     *
     * @throws ClientExceptionInterface If an error happens while processing the request.
    */
    public function sendRequest(RequestInterface $request): ResponseInterface;
}