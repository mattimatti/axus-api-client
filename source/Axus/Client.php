<?php

namespace Axus;

use Axus\Api\AbstractApi;
use Axus\Auth\AuthInterface;
use Axus\Exception\InvalidArgumentException;
use Axus\HttpClient\HttpClient;
use Axus\HttpClient\HttpClientInterface;
use Psr\Log\LoggerInterface;

/**
 * PHP Axus API wrapper.
 */
class Client
{

    /**
     * @var array
     */
    private $options = [
        'base_url' => 'https://axustravelapp.com/api/v1/',
        'username' => null,
        'password' => null,
        'clientId' => null,
        'debug' => false, // This will enable Guzzle Client debug (see Guzzle 6x options)
        'testing' => false
    ];

    /**
     * The class handling communication with Axus servers.
     *
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * The class handling authentication.
     *
     * @var AuthInterface
     */
    private $authenticationClient;


    /**
     * A new PSR-3 Logger like Monolog
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Instantiate a new Axus client.
     *
     * @param null|AuthInterface $authenticationClient Authentication client
     * @param null|HttpClientInterface $httpClient Axus http client
     * @param null|LoggerInterface $logger A PSR3 logger Instance like Monolog
     */
    public function __construct(AuthInterface $authenticationClient = null, HttpClientInterface $httpClient = null, LoggerInterface $logger = null)
    {
        $this->httpClient = $httpClient;
        $this->authenticationClient = $authenticationClient;
        $this->logger = $logger;
    }

    /**
     * @param string $name
     *
     * @return AbstractApi
     * @throws InvalidArgumentException
     *
     */
    public function api($name)
    {
        $apiClass = 'Axus\\Api\\' . ucfirst($name);
        if (class_exists($apiClass)) {
            return new $apiClass($this);
        }

        throw new InvalidArgumentException('API Method not supported: "' . $name . '" (apiClass: "' . $apiClass . '")');
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @throws InvalidArgumentException
     */
    public function setOption($name, $value)
    {
        if (!array_key_exists($name, $this->options)) {
            throw new InvalidArgumentException(sprintf('Undefined option called: "%s"', $name));
        }

        $this->options[$name] = $value;
    }

    /**
     * Retrieves the Auth object and also instantiates it if not already present.
     *
     * @return Auth\AuthInterface
     */
    public function getAuthenticationClient()
    {
        if (null === $this->authenticationClient) {
            $this->authenticationClient = new Auth\Basic($this->getHttpClient(), $this->getOption('username'), $this->getOption('password'));
        }

        return $this->authenticationClient;
    }

    /**
     * @return HttpClientInterface
     */
    public function getHttpClient()
    {
        if (null === $this->httpClient) {
            $this->setHttpClient(new HttpClient($this->options, null, $this->logger));
        }

        return $this->httpClient;
    }

    /**
     * @param HttpClientInterface $httpClient
     */
    public function setHttpClient(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $name
     *
     * @return string
     * @throws InvalidArgumentException
     *
     */
    public function getOption($name)
    {
        if (!array_key_exists($name, $this->options)) {
            throw new InvalidArgumentException(sprintf('Undefined option called: "%s"', $name));
        }

        return $this->options[$name];
    }
}
