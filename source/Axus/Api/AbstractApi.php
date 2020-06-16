<?php

namespace Axus\Api;

use App\Logger;
use Axus\Client;
use Axus\Exception\InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;

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
     * @param string $url
     * @return array
     */
    public function put($url, $parameters = [])
    {
        $httpClient = $this->client->getHttpClient();
        return $httpClient->put($url, $parameters);
    }


    /**
     * @param $url
     * @param array $parameters
     * @return mixed
     */
    public function get($url, $parameters = [])
    {
        $httpClient = $this->client->getHttpClient();
        return $httpClient->get($url, $parameters);
    }


    /**
     * @param ResponseInterface $response
     * @return array
     */
    protected function parseResponse(ResponseInterface $response)
    {
        if ($body = $response->getBody()) {
            $data = json_decode($body, true);
            $this->parseErrors($data);
            return $data;
        }
        return [];
    }


    /**
     * @param array $responseArray
     */
    protected function parseErrors(array $responseArray)
    {
        if (array_key_exists('errors', $responseArray)) {
            if (!empty($responseArray['errors'])) {
                foreach ($responseArray['errors'] as $error) {
                    throw new \Exception($error);
                }
            }
        }
    }


    /**
     * @param $key
     * @param $parameters
     */
    protected function validateArgument($key, $arguments)
    {
        if (!array_key_exists($key, $arguments)) {
            throw new InvalidArgumentException("Missing argument $key");
        }
    }


    /**
     * @param $key
     * @param $parameters
     */
    protected function validateParameter($key, $parameters)
    {
        if (!array_key_exists($key, $parameters)) {
            throw new InvalidArgumentException("Missing parameter $key");
        }
    }
}
