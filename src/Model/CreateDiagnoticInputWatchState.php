<?php

namespace IDCI\Bundle\SAMClientBundle\Model;

class CreateDiagnosticInputWatchState
{
    private bool $printOnEstimate;
    private ?string $internalComment;
    private ?string $materialReference;
    private ?string $productState;

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

    public function getProductState(): string
    {
        return $this->productState;
    }

    public function setProductState(string $productState): self
    {
        $this->productState = $productState;

        return $this;
    }
}
