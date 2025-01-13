<?php

namespace IDCI\Bundle\SAMClientBundle\Model;

use IDCI\Bundle\SAMClientBundle\Model\CodeText;

class BusinessDealsUpdatedSinceApi
{
    private ?array $businessDeals;

    public function __construct(?array $businessDeals)
    {
        $this->businessDeals = $businessDeals;
    }

    public function getBusinessDeals(): ?array
    {
        return $this->businessDeals;
    }
}
