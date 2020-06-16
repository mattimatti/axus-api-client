<?php

namespace Axus\tests\HttpClient;

use Axus\HttpClient\HttpClient;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class HttpClientTest extends TestCase
{

    public function testOptionsToConstructor()
    {
        $httpClient = new TestHttpClient([
            'headers' => [
                'Cache-Control' => 'no-cache'
            ]
        ]);

        $this->assertSame([
            'Cache-Control' => 'no-cache'
        ], $httpClient->getOption('headers'));
        $this->assertNull($httpClient->getOption('base_uri'));
    }

    public function testDoPUTRequest()
    {
        $path = '/some/path';
        $parameters = [
            'a' => 'b'
        ];

        $mock = new MockHandler([
            new Response(200, [
                'Content-Type' => 'application/json'
            ], json_encode([
                'data' => 'ok !'
            ]))
        ]);
        $handler = HandlerStack::create($mock);
        $client = new GuzzleClient([
            'handler' => $handler
        ]);

        $httpClient = new HttpClient([], $client);
        $response = $httpClient->put($path, $parameters);

        $result = $httpClient->parseResponse($response);

        $this->assertSame('ok !', $result);
    }

    public function testDoCustomRequest()
    {
        $path = '/some/path';
        $options = [
            'c' => 'd'
        ];

        $mock = new MockHandler([
            new Response(200, [
                'Content-Type' => 'application/json'
            ], json_encode([
                'data' => true
            ]))
        ]);
        $handler = HandlerStack::create($mock);
        $client = new GuzzleClient([
            'handler' => $handler
        ]);

        $httpClient = new HttpClient([], $client);
        $response = $httpClient->performRequest($path, $options, 'HEAD');

        $result = $httpClient->parseResponse($response);

        $this->assertTrue($result);
    }


}

class TestHttpClient extends HttpClient
{

    public function getOption($name, $default = null)
    {
        return isset($this->options[$name]) ? $this->options[$name] : $default;
    }
}
