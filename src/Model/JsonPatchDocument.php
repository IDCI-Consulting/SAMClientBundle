<?php

namespace IDCI\Bundle\SAMClientBundle\Model;

use IDCI\Bundle\SAMClientBundle\Model\Enum\JsonPatchDocumentOperation;

class JsonPatchDocument
{
    private JsonPatchDocumentOperation $op;
    private ?string $path = null;
    private mixed $value;
    private ?string $from = null;

    public function getOp(): JsonPatchDocumentOperation
    {
        return $this->op;
    }

    public function setOp(JsonPatchDocumentOperation $op): self
    {
        $this->op = $op;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function setValue(mixed $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getFrom(): ?string
    {
        return $this->from;
    }

    public function setFrom(?string $from): self
    {
        $this->from = $from;

        return $from;
    }
}
