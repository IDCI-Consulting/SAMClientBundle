<?php

namespace IDCI\Bundle\SAMClientBundle\Model;

class BusinessDealsUpdatedSinceApi
{
    private ?array $businessDeals = null;

    public function __construct(?array $businessDeals)
    {
        $this->businessDeals = $businessDeals;
    }

    public function getBusinessDeals(): ?array
    {
        return $this->businessDeals;
    }
}
