<?php

declare(strict_types=1);

namespace Cardoza\Ebay;

use Cardoza\Ebay\Token;

class Order
{
    private $accessToken;
    private $client;

    /**
     * Instantiate a new Order class.
     *
     * @param string $token The ebay access token
     */
    public function __construct(string $token)
    {
        $token = new Token();
        $this->accessToken = $token->getAccessToken();

        $this->client = new GuzzleHttpClient();
    }

    /**
     * Retrieves all orders.
     *
     * @param int $limit The number of orders to return
     * @param int $offset The number of orders to skip
     * @return array
     */
    public function getAll(int $limit = 100, int $offset = 0): array
    {
        $response = $this->client->sendRequest(
            'GET',
            '/sell/fulfillment/v1/order/?limit=' . $limit . '&offset=' . $offset,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken
                ]
            ]
        );

        $response = (array) json_decode($response->getBody()->getContents(), true);

        return $response;
    }

    /**
     * Retrieves an order by its ID.
     *
     * @param string $id The ebay order ID
     * @return array
     */
    public function getById(string $id): array
    {
        $response = $this->client->sendRequest(
            'GET',
            '/sell/fulfillment/v1/order/?orderIds=' . $id,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken
                ]
            ]
        );

        $response = (array) json_decode($response->getBody()->getContents(), true);

        return $response;
    }
}
