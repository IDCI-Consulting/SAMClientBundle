<?php

namespace IDCI\Bundle\SAMClientBundle\Model;

use IDCI\Bundle\SAMClientBundle\Model\Enum\CreateDiagnosticInputWatchStateProductState;

class CreateDiagnosticInputWatchState
{
    private bool $toPrint;
    private ?string $internalComment = null;
    private ?string $materialReference = null;
    private CreateDiagnosticInputWatchStateProductState $productState;

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

    public function getProductState(): CreateDiagnosticInputWatchStateProductState
    {
        return $this->productState;
    }

    public function setProductState(CreateDiagnosticInputWatchStateProductState $productState): self
    {
        $this->productState = $productState;

        return $this;
    }
}
