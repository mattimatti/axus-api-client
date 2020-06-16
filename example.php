<?php


use Axus\Client;

$client = new Client();
$client->setOption('username', 'USERNAME');
$client->setOption('password', 'PASSWORD');
$client->setOption('clientId', 'CLIENT-ID');

// eventually use this to log the request
$handle = fopen("/tmp/axus.log", "w");
$client->setOption('debug', $this->handle);

// GETTING THE TOKEN
$token = $client->api('token')->get();

// GETTING AN ITINERARY TOKEN
$itineraries = $client->api('itinerary')->get();



// UPDATING AN ITINERARY
$payload = json_decode('{
  "title": "MY TITLE",
  "id" : "123456",
  "travelers": [],
  "collaborators": [],
  "bookings": []
}', true);

$response = $client->api('itinerary')->push($payload);
