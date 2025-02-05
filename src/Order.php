<?php

declare(strict_types=1);

namespace Cardoza\Ebay;

use Cardoza\Ebay\Token;

class Order
{
    private $accessToken;
    private $client;

    public function __construct(string $token)
    {
        $token = new Token();
        $this->accessToken = $token->getAccessToken();

        $this->client = new GuzzleHttpClient();
    }

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
