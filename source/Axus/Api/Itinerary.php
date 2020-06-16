<?php

namespace Axus\Api;

/**
 * CRUD for Itineraries.
 *
 * @link https://axustravelapp.com/api/v1/push/itinerary
 *
 * @author Matteo Monti <developers@qofclubs.com>
 */
class Itinerary extends AbstractApi
{

    /**
     * @param array $parameters
     * @return array
     */
    public function push(array $parameters = [])
    {
        return $this->put('push/itinerary', $parameters);
    }


    /**
     * @param array $parameters
     * @return array
     */
    public function getAll(array $parameters = [])
    {
        $this->validateArgument('token', $parameters);
        $response = $this->get("pull/itinerary", $parameters);
        $data = $this->parseResponse($response);
        return $data['itineraries'];
    }

    /**
     * @param array $parameters
     * @return array
     */
    public function getById(array $parameters = [])
    {
        $this->validateArgument('token', $parameters);
        $this->validateArgument('itineraryId', $parameters);
        $response = $this->get("pull/itinerary", $parameters);
        $data = $this->parseResponse($response);
        $this->validateParameter('itinerary', $data);
        return $data['itinerary'];
    }


    /**
     * @param array $parameters
     * @return array
     */
    public function getByAdvisorId(array $parameters = [])
    {
        $this->validateArgument('token', $parameters);
        $this->validateArgument('advisorId', $parameters);
        $response = $this->get("pull/itinerary", $parameters);
        $data = $this->parseResponse($response);
        return $data['itineraries'];
    }


    /**
     * @param array $parameters
     * @return array
     */
    public function getByTravellerId(array $parameters = [])
    {
        $this->validateArgument('token', $parameters);
        $this->validateArgument('travelerId', $parameters);
        $response = $this->get("pull/itinerary", $parameters);
        $data = $this->parseResponse($response);
        return $data['itineraries'];
    }

    /**
     * @param array $parameters
     * @return array
     */
    public function getByTravellerAndAdvisorId(array $parameters = [])
    {
        $this->validateArgument('token', $parameters);
        $this->validateArgument('travelerId', $parameters);
        $this->validateArgument('advisorId', $parameters);
        $response = $this->get("pull/itinerary", $parameters);
        $data = $this->parseResponse($response);
        return $data['itineraries'];
    }

}
