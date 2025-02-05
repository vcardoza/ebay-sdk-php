<?php

declare(strict_types=1);

namespace Cardoza\Ebay;

use Cardoza\Ebay\Token;
use Cardoza\Ebay\Order;

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
    public function __construct()
    {
        $this->tokenObj = new Token();
        $this->accessToken = $this->tokenObj->getAccessToken();
    }

    /**
     * Gets the Token object.
     *
     * @return object The Token object
     */
    public function token(): object
    {
        return $this->tokenObj;
    }

    /**
     * Creates and returns a new Order object.
     *
     * @return object An instance of the Order class initialized with the current access token.
     */
    public function orders(): object
    {
        return new Order($this->accessToken);
    }
}
