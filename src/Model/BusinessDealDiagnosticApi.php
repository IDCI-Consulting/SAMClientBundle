<?php

namespace IDCI\Bundle\SAMClientBundle\Model;

class BusinessDealDiagnosticApi
{
    private int $id;
    private string $date;
    private ?array $watchStates = null;
    private ?array $operations = null;
    private int $index;

    public function __construct(?array $watchStates, ?array $operations, int $index)
    {
        $this->watchStates = $watchStates;
        $this->operations = $operations;
        $this->index = $index;
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
}
