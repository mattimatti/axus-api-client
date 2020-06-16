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
     * Request standard itinerary information.
     *
     * @param string $username
     *
     * @link https://axustravelapp.com/api/v1/docs#itinerary
     *
     */
    public function base()
    {
        return $this->put('itinerary');
    }
}
