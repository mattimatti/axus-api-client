<?php
namespace Axus;

use Axus\Auth\AuthInterface;
use Axus\Exception\InvalidArgumentException;
use Axus\HttpClient\HttpClient;
use Axus\HttpClient\HttpClientInterface;

/**
 * PHP Axus API wrapper.
 */
class Client
{

    /**
     * @var array
     */
    private $options = [
        'base_url' => 'https://axustravelapp.com/api/v1/push/',
        'username' => null,
        'password' => null,
        'clientId' => null,
        'testing' => false
    ];

    /**
     * The class handling communication with Axus servers.
     *
     * @var \Axus\HttpClient\HttpClientInterface
     */
    private $httpClient;

    /**
     * The class handling authentication.
     *
     * @var \Axus\Auth\AuthInterface
     */
    private $authenticationClient;

    /**
     * Instantiate a new Axus client.
     *
     * @param null|HttpClientInterface $httpClient Axus http client
     */
    public function __construct(AuthInterface $authenticationClient = null, HttpClientInterface $httpClient = null)
    {
        $this->httpClient = $httpClient;
        $this->authenticationClient = $authenticationClient;
    }

    /**
     * @param string                     $name
     *
     * @throws InvalidArgumentException
     *
     * @return ApiInterface
     */
    public function api($name)
    {
        $apiClass = 'Axus\\Api\\' . ucfirst($name);
        if (class_exists($apiClass)) {
            return new $apiClass($this);
        }
        
        throw new InvalidArgumentException('API Method not supported: "' . $name . '" (apiClass: "'. $apiClass . '")');
    }

    /**
     * @return \Axus\HttpClient\HttpClientInterface
     */
    public function getHttpClient()
    {
        if (null === $this->httpClient) {
            $this->setHttpClient(new HttpClient($this->options));
        }
        
        return $this->httpClient;
    }

    /**
     * @param \Axus\HttpClient\HttpClientInterface $httpClient
     */
    public function setHttpClient(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $name
     *
     * @throws InvalidArgumentException
     *
     * @return string
     */
    public function getOption($name)
    {
        if (! array_key_exists($name, $this->options)) {
            throw new InvalidArgumentException(sprintf('Undefined option called: "%s"', $name));
        }
        
        return $this->options[$name];
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @throws InvalidArgumentException
     */
    public function setOption($name, $value)
    {
        if (! array_key_exists($name, $this->options)) {
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
}
