<?php

namespace Axus\tests\Middleware;

use Axus\Middleware\AuthMiddleware;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class AuthMiddlewareTest extends TestCase
{

    public function testDefineClientIdOnBadToken()
    {
        $clientId = 'clientid';

        $mock = new MockHandler([
            function (RequestInterface $request, array $options) {
                $this->assertEquals('clientid', $request->getHeaderLine('ClientId'));

                return new Response(200);
            }
        ]);

        $stack = new HandlerStack($mock);
        $stack->push(Middleware::mapRequest(function (RequestInterface $request) use ($clientId) {
            return (new AuthMiddleware($clientId))->addAuthHeader($request);
        }));

        $handler = $stack->resolve();
        $request = new Request('GET', 'http://example.com?a=b');
        $promise = $handler($request, []);

        $this->assertInstanceOf(PromiseInterface::class, $promise);
    }
}
