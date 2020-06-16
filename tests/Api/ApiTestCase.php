<?php

namespace Axus\tests\Api;

use Axus\Client;
use Axus\HttpClient\HttpClient;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

abstract class ApiTestCase extends TestCase
{


    /**
     * @return Client
     */
    protected function buildMockRequest($file): Client
    {
        $mock = new MockHandler([
            new Response(200, [
                'Content-Type' => 'application/json'
            ], json_encode($this->loadFixture($file)))
        ]);
        $handler = HandlerStack::create($mock);
        $guzzleClient = new GuzzleClient([
            'handler' => $handler
        ]);

        $httpClient = new HttpClient([], $guzzleClient);
        $client = new Client(null, $httpClient);
        return $client;
    }

    protected function getApiMock()
    {
        $httpClient = $this->getMockBuilder('Axus\HttpClient\HttpClient')
            ->disableOriginalConstructor()
            ->getMock();
        $httpClient->expects($this->any())
            ->method('put');

        $client = new Client(null, $httpClient);

        return $this->getMockBuilder($this->getApiClass())
            ->setMethods([
                'put'
            ])
            ->setConstructorArgs([
                $client
            ])
            ->getMock();
    }

    abstract protected function getApiClass();

    /**
     *
     * @param unknown $filename
     * @return mixed
     */
    protected function loadFixture($filename)
    {
        $path = __DIR__;
        $json = file_get_contents($path . '/../fixtures/' . $filename);
        return json_decode($json, true);
    }


}
