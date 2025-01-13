<?php

namespace IDCI\Bundle\SAMClientBundle\Model;

class CreateDiagnosticInputOperation
{
    private bool $printOnEstimate;
    private ?string $internalComment;
    private ?string $materialReference;
    private bool $mandatory;
    private bool $main;
    private ?float $quantity;

    public function getPrintOnEstimate(): bool
    {
        return $this->printOnEstimate;
    }

    public function setPrintOnEstimate(bool $printOnEstimate): self
    {
        $this->printOnEstimate = $printOnEstimate;

        return $this;
    }

    public function getInternalComment(): ?string
    {
        return $this->internalComment;
    }

    public function setInternalComment(?string $internalComment): self
    {
        $this->internalComment = $internalComment;

        return $this;
    }

    public function getMaterialReference(): ?string
    {
        return $this->materialReference;
    }

    public function setMaterialReference(?string $materialReference): self
    {
        $this->materialReference = $materialReference;

        return $this;
    }

    public function getMandatory(): bool
    {
        return $this->mandatory;
    }

    public function setMandatory(bool $mandatory): self
    {
        $this->mandatory = $mandatory;

        return $this;
    }

    public function getMain(): bool
    {
        return $this->main;
    }

    public function setMain(): self
    {
        $this->main = $main;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(?float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
