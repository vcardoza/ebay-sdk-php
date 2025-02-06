<?php

declare(strict_types=1);

namespace Cardoza\Ebay\Api;

use Cardoza\Ebay\Api\ApiInterface;

class Store implements ApiInterface
{

    private $client;
    /**
     * Instantiate a new Store class.
     *
     * @param object $client The Guzzle client object.
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * Retrieve store information.
     *
     * @return array
     */
    public function getAll(): array
    {
        $response = $this->client->sendRequest(
            'GetStore'
        );

        return $response;
    }

    /**
     * Retrieves a store by its ID.
     *
     * @param string $id The ebay store ID
     * @return array
     */
    public function getById(string $id): array
    {
        return [];
    }
}
