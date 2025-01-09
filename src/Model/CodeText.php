<?php

namespace IDCI\Bundle\SAMClientBundle\Model;

class CodeText
{
    private ?string $code;
    private ?string $text;

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function setText(): ?string
    {
        return $this->text;
    }

    public function getText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }
}
