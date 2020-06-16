<?php

namespace Axus\tests;

use Axus\Client;
use Axus\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @author mattimatti
 *
 */
class ClientTest extends TestCase
{

    public function testNoParameters()
    {
        $client = new Client();
        $this->assertInstanceOf('Axus\HttpClient\HttpClient', $client->getHttpClient());
        $this->assertInstanceOf('Axus\Auth\Basic', $client->getAuthenticationClient());
    }

    public function testAuthenticationParameter()
    {
        $client = new Client($this->getAuthenticationClientMock());
        $this->assertInstanceOf('Axus\HttpClient\HttpClient', $client->getHttpClient());
        $this->assertInstanceOf('Axus\Auth\AuthInterface', $client->getAuthenticationClient());
    }

    private function getAuthenticationClientMock(array $methods = [])
    {
        $methods = array_merge([
            'sign'
        ], $methods);

        return $this->getMockBuilder('Axus\Auth\Basic')
            ->disableOriginalConstructor()
            ->setMethods($methods)
            ->getMock();
    }

    public function testHttpParameter()
    {
        $client = new Client(null, $this->getHttpClientMock());
        $this->assertInstanceOf('Axus\HttpClient\HttpClientInterface', $client->getHttpClient());
        $this->assertInstanceOf('Axus\Auth\Basic', $client->getAuthenticationClient());
    }

    private function getHttpClientMock(array $methods = [])
    {
        $methods = array_merge([
            'get',
            'post',
            'put',
            'delete',
            'request',
            'performRequest',
            'createRequest',
            'parseResponse'
        ], $methods);

        return $this->getMockBuilder('Axus\HttpClient\HttpClient')
            ->disableOriginalConstructor()
            ->setMethods($methods)
            ->getMock();
    }

    public function testBothParameter()
    {
        $client = new Client($this->getAuthenticationClientMock(), $this->getHttpClientMock());
        $this->assertInstanceOf('Axus\HttpClient\HttpClientInterface', $client->getHttpClient());
        $this->assertInstanceOf('Axus\Auth\AuthInterface', $client->getAuthenticationClient());
    }

    /**
     * @dataProvider getApiClassesProvider
     */
    public function testGetApiInstance($apiName, $class)
    {
        $client = new Client();
        $this->assertInstanceOf($class, $client->api($apiName));
    }

    public function getApiClassesProvider()
    {
        return [
            [
                'itinerary',
                'Axus\Api\Itinerary'
            ]
        ];
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testNotGetApiInstance()
    {
        $client = new Client();
        $client->api('do_not_exist');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetOptionNotDefined()
    {
        $client = new Client();
        $client->getOption('do_not_exist');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetOptionNotDefined()
    {
        $client = new Client();
        $client->setOption('do_not_exist', 'value');
    }

    /**
     * @dataProvider getOptions
     */
    public function testGetOption($option, $value)
    {
        $client = new Client();
        $client->setOption($option, $value);

        $this->assertSame($value, $client->getOption($option));
    }

    public function getOptions()
    {
        return [
            [
                'base_url',
                'url'
            ],
            [
                'username',
                'username'
            ],
            [
                'clientId',
                'clientid'
            ],
            [
                'password',
                'secret'
            ]
        ];
    }

}
