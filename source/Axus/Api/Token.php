<?php

namespace Axus\Api;

use Psr\Http\Message\ResponseInterface;

/**
 * Token Endpoint.
 *
 * @link https://axustravelapp.com/api/v1/pull/token
 *
 * @author Matteo Monti <developers@qofclubs.com>
 */
class Token extends AbstractApi
{

    /**
     * @return string
     * @throws \Exception|\InvalidArgumentException
     */
    public function getToken()
    {
        return $this->parseToken($this->get("pull/token"));
    }

    /**
     * @param ResponseInterface $response
     * @return string
     * @throws \Exception|\InvalidArgumentException
     */
    private function parseToken(ResponseInterface $response)
    {
        $data = $this->parseResponse($response);
        $this->parseErrors($data);
        $this->validateParameter('token', $data);
        return $data['token'];
    }

}
