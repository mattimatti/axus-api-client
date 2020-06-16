<?php
namespace Axus\tests\Auth;

use Axus\Auth\Basic;
use Axus\HttpClient\HttpClient;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class BasicTest extends TestCase
{

    public function testGetAuthenticationUrl()
    {
        $client = new GuzzleClient();

        $auth = new Basic(new HttpClient([], $client), 'matti', 'matti');

        $expected = [
            'auth' => [
                'matti',
                'matti'
            ]
        ];

        $this->assertEquals($expected, $auth->sign());
    }

    public function testAuthenticatedRequest()
    {
        $mock = new MockHandler([
            new Response(200, [
                'Content-Type' => 'application/json'
            ], json_encode([
                'data' => [
                    'access_token' => 'T0K3N',
                    'expires_in' => 3600
                ]
            ])),
            new Response(200)
        ]);
        $handler = HandlerStack::create($mock);
        $client = new GuzzleClient([
            'handler' => $handler
        ]);

        $httpClient = new HttpClient([], $client);

        $auth = new Basic($httpClient, 123, 456);
        $auth->sign();

        $httpClient->put('http://google.com');
    }
}
