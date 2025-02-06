<?php

declare(strict_types=1);

namespace Cardoza\Ebay\Api;

class Inventory
{
    private object $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function getAll(): array
    {
        $response = $this->client->sendRequest(
            'GetItem',
            []
        );

        $response = (array) json_decode($response->getBody()->getContents(), true);

        return $response;
    }

    public function getById(string $id): array
    {
        return [];
    }
}
