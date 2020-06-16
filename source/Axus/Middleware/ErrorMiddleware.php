<?php

namespace Axus\Middleware;

use Axus\Exception\ErrorException;
use Axus\Exception\RuntimeException;
use Closure;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ErrorMiddleware
{

    /**
     */
    private $nextHandler;

    /**
     * @param callable $nextHandler Next handler to invoke
     */
    public function __construct(callable $nextHandler)
    {
        $this->nextHandler = $nextHandler;
    }

    /**
     * Middleware that handles rate limit errors.
     *
     * @return Closure Returns a function that accepts the next handler
     */
    public static function error()
    {
        return function (callable $handler) {
            return new self($handler);
        };
    }

    /**
     * @param RequestInterface $request
     * @param array $options
     *
     * @return PromiseInterface
     */
    public function __invoke(RequestInterface $request, array $options)
    {
        $fn = $this->nextHandler;

        return $fn($request, $options)->then(function (ResponseInterface $response) {
            return $this->checkError($response);
        });
    }

    /**
     * Check for an error.
     *
     * @param ResponseInterface $response
     */
    public function checkError(ResponseInterface $response)
    {
        if ($response->getStatusCode() < 400) {
            return $response;
        }

        if ($response->getStatusCode() == 401) {
            throw new ErrorException('Authentication required');
        }

        $body = (string)$response->getBody();
        $responseData = json_decode($body, true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            $responseData = $body;
        }

        if (is_array($responseData) && isset($responseData['data']) && isset($responseData['data']['error'])) {
            throw new ErrorException('Request to: ' . $responseData['data']['request'] . ' failed with: "' . $responseData['data']['error'] . '"', $response->getStatusCode());
        }

        throw new RuntimeException(is_array($responseData) && isset($responseData['message']) ? $responseData['message'] : $responseData, $response->getStatusCode());
    }

}
