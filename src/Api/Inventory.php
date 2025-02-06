<?php

declare(strict_types=1);

namespace Cardoza\Ebay\Api;

use Cardoza\Ebay\Api\ApiInterface;

class Inventory implements ApiInterface
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
