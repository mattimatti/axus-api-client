<?php
namespace Axus\tests\Middleware;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Axus\Middleware\AuthMiddleware;
use Psr\Http\Message\RequestInterface;

class AuthMiddlewareTest extends \PHPUnit_Framework_TestCase
{

    public function testDefineClientIdOnBadToken()
    {
        $clientId = 'clientid';
        
        $mock = new MockHandler([
            function (RequestInterface $request, array $options) {
                $this->assertEquals('ClientId clientid', $request->getHeaderLine('Authorization'));
                
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
