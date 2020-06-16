<?php

namespace Axus\Api;

use Axus\Client;
use Axus\Exception\InvalidArgumentException;

/**
 * Abstract class supporting API requests.
 *
 * @author Matteo Monti <developers@qofclubs.com>
 */
abstract class AbstractApi
{

    /**
     * @var Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Perform a PUT request and return the parsed response.
     *
     * @param string $url
     *
     * @return array
     */
    public function put($url, $parameters = [])
    {
        $httpClient = $this->client->getHttpClient();

        $parameters = array_merge($parameters, $this->client->getAuthenticationClient()->sign());

        $response = $httpClient->put($url, $parameters);

        return $httpClient->parseResponse($response);
    }

    /**
     * Global method to validate an argument.
     *
     * @param string $type The required parameter (used for the error message)
     * @param string $input Input value
     * @param array $possibleValues Possible values for this argument
     */
    private function validateArgument($type, $input, $possibleValues)
    {
        if (!in_array($input, $possibleValues, true)) {
            throw new InvalidArgumentException($type . ' parameter "' . $input . '" is wrong. Possible values are: ' . implode(', ', $possibleValues));
        }
    }
}
