<?php

namespace Axus\HttpClient;

use Axus\Middleware\AuthMiddleware;
use Axus\Middleware\ErrorMiddleware;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;

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
        'base_url' => 'https://axustravelapp.com/api/v1/push/',
        'clientId' => null
    ];

    protected $stack;

    /**
     * @param array $options
     * @param ClientInterface $client
     */
    public function __construct(array $options = [], ClientInterface $client = null)
    {
        $this->options = array_merge($options, $this->options);

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
     * {@inheritdoc}
     */
    public function put($url, array $parameters = [])
    {
        return $this->performRequest($url, $parameters, 'PUT');
    }

    /**
     * {@inheritdoc}
     */
    public function performRequest($url, $parameters, $httpMethod = 'GET')
    {
        $options = [
            'headers' => [],
            'body' => ''
        ];

        // if (isset($this->options['clientId'])) {
        // $options['headers'][] = $this->options['clientId'];
        // }

        if (isset($parameters['query'])) {
            $options['query'] = $parameters['query'];
        }

        if ($httpMethod === 'POST' || $httpMethod === 'PUT' || $httpMethod === 'DELETE') {
            $options['json'] = $parameters;
        }

        $this->addAuthMiddleware($this->options['clientId']);

        // will throw an Axus\Exception\ExceptionInterface if sth goes wrong
        return $this->client->request($httpMethod, $url, $options);
    }

    /**
     * Push authorization middleware.
     *
     * @param array $token
     * @param string $clientId
     */
    public function addAuthMiddleware($clientId)
    {
        $this->stack->push(Middleware::mapRequest(function (RequestInterface $request) use ($clientId) {
            return (new AuthMiddleware($clientId))->addAuthHeader($request);
        }));
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
            $responseBody = json_decode($response->getBody(), true);
        }

        return $responseBody['data'];
    }
}
