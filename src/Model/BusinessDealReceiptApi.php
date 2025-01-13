<?php

namespace IDCI\Bundle\SAMClientBundle\Model;

use IDCI\Bundle\SAMClientBundle\Model\CodeText;

class BusinessDealReceiptApi
{
    private int $id;
    private string $date;
    private ?array $components;
    private ?array $comments;
    private int $index;
    private ?string $customerAddressText;
    private CodeText $language;

    public function __construct(?array $components, ?array $comments)
    {
        $this->components = $components;
        $this->comments = $comments;
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

    public function getComponents(): ?array
    {
        return $this->components;
    }

    public function getComments(): ?array
    {
        return $this->comments;
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
}
