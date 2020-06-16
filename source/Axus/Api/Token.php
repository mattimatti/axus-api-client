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
     * @param array $parameters
     * @return array
     */
    public function getToken(array $parameters = [])
    {
        return $this->parseToken($this->get("pull/token"));
    }

    /**
     * @param ResponseInterface $response
     * @return mixed
     * @throws \Exception
     */
    private function parseToken(ResponseInterface $response)
    {
        $data = $this->parseResponse($response);
        $this->parseErrors($data);
        return $data['token'];
    }

}
