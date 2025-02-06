<?php

declare(strict_types=1);

namespace Cardoza\Ebay\Api;

use Cardoza\Ebay\Api\ApiInterface;

class Feedback implements ApiInterface
{
    private $client;
    public function __construct(object $client)
    {
        $this->client = $client;
    }
    public function getAll($limit = 100, $offset = 0): array
    {
        $response = $this->client->sendRequest("GetFeedback", [
            'DetailLevel' => 'ReturnAll',
            'Pagination' => array('EntriesPerPage' => $limit, 'PageNumber' => $offset + 1)
        ]);

        return $response;
    }
    public function getById(string $id): array
    {
        $response = $this->client->sendRequest("GetFeedback", [
            'FeedbackID' => $id,
            'DetailLevel' => 'ReturnAll'
        ]);
        return $response;
    }
}
