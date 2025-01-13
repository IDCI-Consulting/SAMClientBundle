<?php

namespace IDCI\Bundle\SAMClientBundle\Model;

use IDCI\Bundle\SAMClientBundle\Model\BusinessDealActivityApi;

class ActivityUpdatedApi
{
    private int $id;
    private ?string $internalNumber;
    private ?string $externalId;
    private BusinessDealActivityApi $businessDealActivity;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getInternalNumber(): ?string
    {
        return $this->internalNumber;
    }

    public function setInternalNumber(?string $internalNumber): self
    {
        $this->internalNumber = $internalNumber;

        return $this;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setExternalId(?string $externalId): self
    {
        $this->externalId = $externalId;

        return $this;
    }

    public function getBusinessDealActivity(): BusinessDealActivityApi
    {
        return $this->businessDealActivity;
    }

    public function setBusinessDealActivity(BusinessDealActivityApi $businessDealActivity): self
    {
        $this->businessDealActivity = $businessDealActivity;

        return $this;
    }
}
