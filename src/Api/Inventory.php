<?php

declare(strict_types=1);

namespace Cardoza\Ebay\Api;

class Inventory
{
    private object $client;

    /**
     * Constructor.
     *
     * @param object $client An instance of the Cardoza\Ebay\SoapClient class
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * Retrieves a list of all inventory items from eBay.
     *
     * @param int $limit The maximum number of inventory items to return
     * @param int $offset The number of inventory items to skip before starting to collect the result set
     * @return array An array containing the inventory items
     */
    public function getAll(int $limit = 100, int $offset = 0): array
    {
        $response = $this->client->sendRequest(
            'GetMyeBaySelling',
            [
                'DetailLevel' => 'ReturnAll',
                ['Pagination' => ['EntriesPerPage' => $limit, 'PageNumber' => $offset + 1]]
            ]
        );

        return $response;
    }

    /**
     * @param string $id
     * @return array
     */
    public function getById(string $id): array
    {
        $response = $this->client->sendRequest(
            'GetItem',
            [
                'DetailLevel' => 'ReturnAll',
                'ItemID' => $id
            ]
        );
        return $response;
    }
}
