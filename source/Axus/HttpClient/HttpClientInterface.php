<?php

namespace Axus\HttpClient;

use Psr\Http\Message\ResponseInterface;

/**
 * Basic client for performing HTTP requests.
 *
 * @author Matteo Monti <developers@qofclubs.com>
 */
interface HttpClientInterface
{


    /**
     * Perform a PUT request.
     *
     * @param string $url URL to which the request should point
     * @param array $parameters Request parameters
     *
     * @return ResponseInterface
     */
    public function put($url, array $parameters = []);


    /**
     * Perform the actual request.
     *
     * @param string $url URL to which the request should point
     * @param array $parameters Request parameters
     * @param string $httpMethod HTTP method to use
     *
     * @return ResponseInterface
     */
    public function performRequest($url, $parameters, $httpMethod = 'GET');

    /**
     * Parses the Axus server response.
     *
     * @param object $response
     *
     * @return array
     */
    public function parseResponse($response);
}
