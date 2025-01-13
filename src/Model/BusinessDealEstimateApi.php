<?php

namespace IDCI\Bundle\SAMClientBundle\Model;

use IDCI\Bundle\SAMClientBundle\Model\CodeText;

class BusinessDealEstimateApi
{
    private int $id;
    private string $date;
    private ?array $watchStates;
    private ?array $operations;
    private int $index;
    private ?bool $taxIncluded;
    private ?float $totalAmount;
    private ?string $customerAddressText;
    private CodeText $language;
    private CodeText $currency;

    public function __construct(?array $watchStates, ?array $operations)
    {
        $this->watchStates = $watchStates;
        $this->operations = $operations;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getWatchStates(): ?array
    {
        return $this->watchStates;
    }

    public function getOperations(): ?array
    {
        return $this->operations;
    }

    public function getIndex(): int
    {
        return $this->index;
    }

    public function setIndex(int $index): self
    {
        $this->index = $index;

        return $this;
    }

    public function getTaxIncluded(): ?bool
    {
        return $this->taxIncluded;
    }

    public function setTaxIncluded(?bool $taxIncluded): self
    {
        $this->taxIncluded = $taxIncluded;

        return $this;
    }

    public function getTotalAmount(): ?float
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(?float $totalAmount): self
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    public function getCustomerAddressText(): ?string
    {
        return $this->customerAddressText;
    }

    public function setCustomerAddressText(?string $customerAddressText): self
    {
        $this->customerAddressText = $customerAddressText;

        return $this;
    }

    public function getLanguage(): CodeText
    {
        return $this->language;
    }

    public function setLanguage(CodeText $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getCurrency(): CodeText
    {
        return $this->currency;
    }

    public function setCurrency(CodeText $currency): self
    {
        $this->currency = $currency;

        return $this;
    }
}
