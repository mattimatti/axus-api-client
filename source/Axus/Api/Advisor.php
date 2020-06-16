<?php

namespace Axus\Api;

/**
 * CRUD for Itineraries.
 *
 * @link https://axustravelapp.com/api/v1/push/itinerary
 *
 * @author Matteo Monti <developers@qofclubs.com>
 */
class Advisor extends AbstractApi
{

    /**
     * @param array $parameters
     * @return array
     */
    public function getList(array $parameters = [])
    {
        $this->validateArgument('token', $parameters);
        return $this->get("pull/advisor", $parameters);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public function get(array $parameters = [])
    {
        $this->validateArgument('token', $parameters);
        $this->validateArgument('advisorId', $parameters);
        return $this->get("pull/advisor", $parameters);
    }

}
