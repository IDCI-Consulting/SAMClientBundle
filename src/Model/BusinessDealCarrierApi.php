<?php

namespace IDCI\Bundle\SAMClientBundle\Model;

class BusinessDealCarrierApi
{
    private ?string $carrierReference;
    private ?string $tracking;
    private ?string $trackingUrl;

    public function getCarrierReference(): ?string
    {
        return $this->carrierReference;
    }

    public function setCarrierReference(?string $carrierReference): self
    {
        $this->carrierReference = $carrierReference;

        return $this;
    }

    public function getTracking(): ?string
    {
        return $this->tracking;
    }

    public function setTracking(?string $tracking): self
    {
        $this->tracking = $tracking;

        return $this;
    }

    public function getTrackingUrl(): ?string
    {
        return $this->trackingUrl;
    }

    public function setTrackingUrl(?string $trackingUrl): self
    {
        $this->trackingUrl = $trackingUrl;

        return $this;
    }
}
