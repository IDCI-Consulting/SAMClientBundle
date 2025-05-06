<?php

namespace IDCI\Bundle\SAMClientBundle\Model;

class CreateDiagnosticInputOperation
{
    private bool $toPrint;
    private ?string $internalComment = null;
    private ?string $materialReference = null;
    private bool $mandatory;
    private bool $main;
    private ?float $quantity = null;

    public function isToPrint(): bool
    {
        return $this->toPrint;
    }

    public function setToPrint(bool $toPrint): self
    {
        $this->toPrint = $toPrint;

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

    public function isMandatory(): bool
    {
        return $this->mandatory;
    }

    public function setMandatory(bool $mandatory): self
    {
        $this->mandatory = $mandatory;

        return $this;
    }

    public function isMain(): bool
    {
        return $this->main;
    }

    public function setMain(bool $main): self
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
