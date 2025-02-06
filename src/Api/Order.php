<?php

declare(strict_types=1);

namespace Cardoza\Ebay\Api;

use Cardoza\Ebay\Token;
use Cardoza\Ebay\GuzzleHttpClient;

class Order
{
    private object $client;

    /**
     * Instantiate a new Order class.
     *
     * @param string $token The ebay access token
     */
    public function __construct(object $client)
    {
        $this->client = $client;
    }

    /**
     * Retrieves all orders.
     *
     * @param int $limit The number of orders to return
     * @param int $offset The number of orders to skip
     * @return array
     */
    public function getAll(int $numberOfDays = 30, int $limit = 100, int $offset = 0): array
    {
        $response = $this->client->sendRequest('GetOrders', ['IncludeFinalValueFee' => true, 'NumberOfDays' => $numberOfDays, 'Pagination' => array('EntriesPerPage' => $limit, 'PageNumber' => $offset + 1)]);

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
            'GetOrders',
            [
                'OrderIDArray' => ['OrderID' => $id],
                'IncludeFinalValueFee' => true
            ]
        );

        return $response;
    }
}
