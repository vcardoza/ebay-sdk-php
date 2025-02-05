<?php

declare(strict_types=1);

namespace Cardoza\Ebay;

use GuzzleHttp\Psr7\Response;

class GuzzleHttpClient
{
    private $environment;
    private $accessURL;
    private $client;

    public function __construct()
    {
        $this->environment = ENVIRONMENT;
        // Set the access URL based on the environment
        $this->accessURL = strtolower($this->environment) == "production" ? "https://api.ebay.com" : "https://api.sandbox.ebay.com";

        $this->client = new \GuzzleHttp\Client(['base_uri' => $this->accessURL]);
    }

    public function sendRequest(string $method, string $uri, array $options = []): Response
    {

        $response = $this->client->request($method, $uri, $options);

        return $response;
    }
}
