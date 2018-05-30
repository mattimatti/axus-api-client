<?php
namespace Axus\tests\Api;

use Axus\Client;

abstract class ApiTestCase extends \PHPUnit_Framework_TestCase
{

    abstract protected function getApiClass();

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
    
    
    
    protected function loadFixture($filename){
        $path = __DIR__;
        $json = file_get_contents($path. '/../fixtures/' . $filename);
        return json_decode($json, true);
    }
    
    
}
