<?php

declare(strict_types=1);

namespace Cardoza\Ebay;

use Cardoza\Ebay\Token;
use Cardoza\Ebay\Order;

class Sdk
{
    private $tokenObj;
    private $accessToken;

    public function __construct()
    {
        $this->tokenObj = new Token();
        $this->accessToken = $this->tokenObj->getAccessToken();
    }

    public function token(): object
    {
        return $this->tokenObj;
    }

    public function orders(): object
    {
        return new Order($this->accessToken);
    }
}
