<?php

namespace IDCI\Bundle\SAMClientBundle\Model;

class BusinessDealActivityApi
{
    private CodeText $activity;
    private string $startDate;
    private ?string $endDate;
    private string $status;

    public function getActivity(): CodeText
    {
        return $this->activity;
    }

    public function setActivity(CodeText $activity): self
    {
        $this->activity = $activity;

        return $this;
    }

    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public function setStartDate(string $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function setEndDate(?string $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
