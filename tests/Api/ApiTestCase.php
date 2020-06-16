<?php

namespace Axus\tests\Api;

use Axus\Client;
use PHPUnit\Framework\TestCase;

abstract class ApiTestCase extends TestCase
{

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
