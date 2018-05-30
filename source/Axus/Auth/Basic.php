<?php
namespace Axus\Auth;

use Axus\HttpClient\HttpClientInterface;
use Axus\Exception\AuthException;

/** 
 * @author mattimatti
 * 
 */
class Basic implements AuthInterface
{

    /**
     * 
     * @var string
     */
    private $username;

    /**
     * 
     * @var string
     */
    private $password;

    /**
     * The class handling communication with Axus servers.
     *
     * @var \Axus\HttpClient\HttpClientInterface
     */
    private $httpClient;

    /**
     * 
     */
    public function __construct(HttpClientInterface $httpClient, $username, $password)
    {
        $this->username = $username;
        $this->password = $password;
        $this->httpClient = $httpClient;
    }

    /**
     *(non-PHPdoc) 
     * @see \Axus\Auth\AuthInterface::sign()
     */
    public function sign()
    {
        
        return [
            'auth' => [
                $this->username,
                $this->password
            ]
        ];
    }
}

