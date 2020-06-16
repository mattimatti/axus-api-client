<?php

namespace Axus\HttpClient;

use Axus\Middleware\ErrorMiddleware;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\ResponseInterface;

/**
 * Basic client for performing HTTP requests.
 *
 * @author Matteo Monti <developers@qofclubs.com>
 */
class HttpClient implements HttpClientInterface
{

    /**
     * The Guzzle instance.
     *
     * @var ClientInterface
     */
    protected $client;

    /**
     * HTTP Client Settings.
     *
     * @var array
     */
    protected $options = [
        'base_url' => 'https://axustravelapp.com/api/v1/',
        'clientId' => null
    ];

    protected $stack;

    /**
     * @param array $options
     * @param ClientInterface $client
     */
    public function __construct(array $options = [], ClientInterface $client = null)
    {
        $this->options = array_merge($this->options, $options);

        $baseUrl = $this->options['base_url'];
        unset($this->options['base_url']);

        // during test (at least) handler can be injected into the client
        // so we need to retrieve it to be able to inject our own middleware
        $this->stack = HandlerStack::create();
        if (null !== $client) {
            $this->stack = $client->getConfig('handler');
        }

        $this->stack->push(ErrorMiddleware::error());

        $this->client = $client ?: new GuzzleClient([
            'base_uri' => $baseUrl,
            'handler' => $this->stack
        ]);
    }

    /**
     * Perform a PUT request.
     *
     * @param string $url URL to which the request should point
     * @param array $parameters Request parameters
     *
     * @return ResponseInterface
     */
    public function put($url, array $parameters = [])
    {
        return $this->performRequest($url, $parameters, 'PUT');
    }

    /**
     * Perform a GET request.
     *
     * @param string $url URL to which the request should point
     * @param array $parameters Request parameters
     *
     * @return ResponseInterface
     */
    public function get($url, array $parameters = [])
    {
        return $this->performRequest($url, $parameters, 'GET');
    }


    /**
     * {@inheritdoc}
     */
    public function performRequest($url, $parameters, $httpMethod = 'GET')
    {
        $options = [
            'headers' => [],
            'tiemout' => 5,
            'body' => ''
        ];

        // Add The ClientId header
        if (isset($this->options['clientId'])) {
            $options['headers']['clientId'] = $this->options['clientId'];
//            $options['headers']['User-Agent'] = "PHP Axus Api Client";
        }

        // Setup Basic Auth
        if (isset($this->options['username'])) {
            if (isset($this->options['password'])) {
                $options['auth'] = [$this->options['username'], $this->options['password']];
            }
        }

        if (isset($parameters['query'])) {
            $options['query'] = $parameters['query'];
        }

        if ($httpMethod === 'POST' || $httpMethod === 'PUT' || $httpMethod === 'DELETE') {
            $options['json'] = $parameters;
        }

        if (isset($this->options['debug']) && $this->options['debug'] !== false) {
            $options['debug'] = $this->options['debug'];
        }

        // will throw an Axus\Exception\ExceptionInterface if sth goes wrong
        return $this->client->request($httpMethod, $url, $options);
    }


    /**
     * {@inheritdoc}
     */
    public function parseResponse($response)
    {
        $responseBody = [
            'data' => [],
            'success' => false
        ];

        if ($response) {
            $responseBody = json_decode($response->getBody()->getContents(), true);
        }

        return $responseBody['data'];
    }
}
