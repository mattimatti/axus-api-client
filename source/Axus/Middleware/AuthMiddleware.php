<?php
namespace Axus\Middleware;

use Psr\Http\Message\RequestInterface;

class AuthMiddleware
{


    private $clientId;

    /**
     * Middleware that add Authorization header.
     *
     * @param array  $token
     * @param string $clientId
     */
    public function __construct($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * Add Authorization header to the request.
     *
     * @param RequestInterface $request
     */
    public function addAuthHeader(RequestInterface $request)
    {
        return $request->withHeader('Authorization', 'ClientId ' . $this->clientId);
    }
}
