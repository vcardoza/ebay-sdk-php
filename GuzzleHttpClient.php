<?php

declare(strict_types=1);

namespace Cardoza\Ebay;

use GuzzleHttp\Psr7\Response;

/**
 * Guzzle HTTP client.
 * 
 * @package Cardoza\Ebay
 */
class GuzzleHttpClient
{
    private $environment;
    private $accessURL;
    private $client;
    private $accessToken;

    /**
     * Create a new Guzzle HTTP client.
     *
     * Sets the base URI for the client based on the environment. If the
     * environment is "production", the base URI is "https://api.ebay.com".
     * Otherwise, the base URI is "https://api.sandbox.ebay.com".
     *
     * @return void
     */
    public function __construct()
    {
        if (defined('ENVIRONMENT')) $this->environment = ENVIRONMENT;
        // Set the access URL based on the environment
        $this->accessURL = strtolower($this->environment) == "production" ? "https://api.ebay.com" : "https://api.sandbox.ebay.com";

        $this->client = new \GuzzleHttp\Client(['base_uri' => $this->accessURL]);
    }

    /**
     * Sends a request to the Ebay API.
     *
     * @param string $method HTTP method to use. E.g. GET, POST, PUT, DELETE.
     * @param string $uri URI of the request. E.g. /buy/browse/v1/item/1234567890
     * @param array $options An array of options to pass to the Guzzle client.
     * @return Response The response from the Ebay API.
     */
    public function sendRequest(string $method, string $uri, ?array $options = []): Response
    {
        if (empty($options)) {
            $token = new Token();
            $options = [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token->getAccessToken()
                ]
            ];
        }
        $response = $this->client->request($method, $uri, $options);

        return $response;
    }
}
