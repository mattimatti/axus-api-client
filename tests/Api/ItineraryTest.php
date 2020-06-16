<?php

namespace Axus\tests\Api;

use Axus\Api\Itinerary;

class ItineraryTest extends ApiTestCase
{

    /**
     *
     */
    public function testGetByIdResponse()
    {
        $client = $this->buildMockRequest('itinerary-itin.json');
        $itinerary = new Itinerary($client);

        $result = $itinerary->getById(['token' => '123', 'itineraryId' => '123']);
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
     */
    public function testGetRequiresAToken()
    {
        $this->expectException(\InvalidArgumentException::class);

        $client = $this->buildMockRequest('itinerary-itin.json');
        $itinerary = new Itinerary($client);

        $result = $itinerary->getById(['itineraryId' => '123']);
    }

    /**
     */
    public function testGetByIdRequiresAnId()
    {
        $this->expectException(\InvalidArgumentException::class);

        $client = $this->buildMockRequest('itinerary-itin.json');
        $itinerary = new Itinerary($client);

        $result = $itinerary->getById(['token' => '123']);
    }


    /**
     *
     */
    public function testGetAll()
    {
        $client = $this->buildMockRequest('itinerary-list.json');
        $itinerary = new Itinerary($client);

        $result = $itinerary->getAll(['token' => '123']);
        $this->assertCount(4, $result);
    }

    protected function getApiClass()
    {
        return 'Axus\Api\Itinerary';
    }


}
