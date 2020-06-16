<?php
namespace Axus\tests\Api;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Axus\Api\Account;
use Axus\Client;
use Axus\HttpClient\HttpClient;
use Axus\Api\Itinerary;
use CLIFramework\Logger;

class ItineraryTest extends ApiTestCase
{

    protected function getApiClass()
    {
        return 'Axus\Api\Itinerary';
    }

    /**
     * @expectedException \Axus\Exception\ErrorException
     * @expectedExceptionMessage Authentication required
     */
    public function testBaseReal()
    {
        $guzzleClient = new GuzzleClient([
            'base_uri' => 'https://axustravelapp.com/api/v1/push/'
        ]);
        
//         var_dump($guzzleClient);
//         exit();
        
        $httpClient = new HttpClient([], $guzzleClient);
        
        $client = new Client(null, $httpClient);
        $itinerary = new Itinerary($client);
        
        $result = $itinerary->base();
        
        var_dump($result);
        exit();
    }

    /**
     * 
     */
    public function testBaseWithResponse()
    {
        $mock = new MockHandler([
            new Response(200, [
                'Content-Type' => 'application/json'
            ], json_encode([
                'data' => $this->loadFixture('itinerary-itin.json'),
                'success' => true,
                'status' => 200
            ]))
        ]);
        $handler = HandlerStack::create($mock);
        $guzzleClient = new GuzzleClient([
            'handler' => $handler
        ]);
        
        $httpClient = new HttpClient([], $guzzleClient);
        $client = new Client(null, $httpClient);
        $itinerary = new Itinerary($client);
        
        $result = $itinerary->base();
        
        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('title', $result);
        $this->assertArrayHasKey('startDate', $result);
        $this->assertArrayHasKey('endDate', $result);
        $this->assertArrayHasKey('image', $result);
        $this->assertArrayHasKey('travelers', $result);
        $this->assertArrayHasKey('collaborators', $result);
        $this->assertArrayHasKey('bookings', $result);
    }

    /**
     * 
     */
    public function testBase()
    {
        $expectedValue = [
            'data' => [
                'id' => 123
            ],
            'success' => true,
            'status' => 200
        ];
        
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('itinerary')
            ->will($this->returnValue($expectedValue));
        
        $this->assertSame($expectedValue, $api->base());
    }
}