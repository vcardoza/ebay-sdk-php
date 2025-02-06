<?php

declare(strict_types=1);

namespace Cardoza\Ebay;

use Cardoza\Ebay\Token;
use Cardoza\Ebay\Api\Store;
use Cardoza\Ebay\Api\Order;
use Cardoza\Ebay\Api\Inventory;
use Cardoza\Ebay\Api\Feedback;

class Sdk
{
    private $tokenObj;
    private $accessToken;

    /**
     * Instantiates the SDK object
     *
     * This constructor gets the access token by calling the getAccessToken() method
     * from the Token class.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Creates and returns a new Store object.
     *
     * @return object An instance of the Store class initialized with a Guzzle HTTP client.
     */
    public function store(): object
    {
        return new Store(new SoapClient());
    }

    /**
     * Creates and returns a new Order object.
     *
     * @return object An instance of the Order class initialized with the current access token.
     */
    public function order(): object
    {
        return new Order(new SoapClient());
    }

    public function inventory(): object
    {
        return new Inventory(new SoapClient());
    }

    public function feedback(): object
    {
        return new Feedback(new SoapClient());
    }
}
