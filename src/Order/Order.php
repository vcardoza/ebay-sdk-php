<?php

namespace Cardoza\EbaySdk\Order;

use Cardoza\EbaySdk\EbaySdk;

class Order
{
    private $accessToken;

    public function __construct(EbaySdk $ebaySdk)
    {
        $this->accessToken = $ebaySdk->accessToken;
    }
}
