<?php

namespace IDCI\Bundle\SAMClientBundle\Model;

class BusinessDealProgress
{
    private string $receptionDate;
    private ?string $estimateDate;
    private ?string $expectedDeliveryDate;
    private ?string $workStartDate;
    private ?string $workEndDate;
    private ?string $deliveryDate;
    private ?int $numberDaysWaitingParts

    public function getReceptionDate(): string
    {
        return $this->receptionDate;
    }

    public function setReceptionDate(string $receptionDate): self
    {
        $this->receptionDate = $receptionDate;

        return $this;
    }

    public function getEstimateDate(): ?string
    {
        return $this->estimateDate;
    }

    public function setEstimateDate(?string $estimateDate): self
    {
        $this->estimateDate = $estimateDate;

        return $this;
    }

    public function getExpectedDeliveryDate(): ?string
    {
        return $this->expectedDeliveryDate;
    }

    public function setExpectedDeliveryDate(?string $expectedDeliveryDate): self
    {
        $this->expectedDeliveryDate = $expectedDeliveryDate;

        return $this;
    }

    public function getWorkStartDate(): ?string
    {
        return $this->workStartDate;
    }

    public function setWorkStartDate(?string $workStartDate): self
    {
        $this->workStartDate = $workStartDate;

        return $this;
    }

    public function getWorkEndDate(): ?string
    {
        return $this->workEndDate;
    }

    public function setWorkEndDate(?string $workEndDate): self
    {
        $this->workEndDate = $workEndDate;

        return $this;
    }

    public function getDeliveryDate(): ?string
    {
        return $this->deliveryDate;
    }

    public function setDeliveryDate(?string $deliveryDate): self
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    public function getNumberDaysWaitingParts(): ?int
    {
        return $this->numberDaysWaitingParts;
    }

    public function setNumberDaysWaitingParts(?int $numberDaysWaitingParts): self
    {
        $this->numberDaysWaitingParts = $numberDaysWaitingParts;

        return $this;
    }
}
