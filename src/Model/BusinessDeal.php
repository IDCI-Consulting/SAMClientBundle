<?php

namespace IDCI\Bundle\SAMClientBundle\Model;

class BusinessDeal
{
    private string $externalId;
    private string $partnerReference;
    private ?string $partnerSiteReference = null;
    private ?string $initialRequestorPartnerSiteReference = null;
    private ?string $initialRequestorPartnerReference = null;
    private string $brandReference;
    private ?string $invoicingCode = null;
    private ?string $internalNumber = null;
    private ?string $productNature = null;
    private ?string $productReference = null;
    private ?string $productSerialNumber = null;
    private ?string $externalNumber = null;
    private ?string $batchReference = null;
    private ?string $movementSerialNumberReference = null;
    private ?string $movementReference = null;
    private ?string $interventionCode = null;
    private BusinessDealProgress $progress;
    private ?string $accessCode = null;
    private ?bool $quickService = null;
    private ?string $interventionInvoicingCode = null;

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function setExternalId(string $externalId): self
    {
        $this->externalId = $externalId;

        return $this;
    }

    public function getPartnerReference(): string
    {
        return $this->partnerReference;
    }

    public function setPartnerReference(string $partnerReference): self
    {
        $this->partnerReference = $partnerReference;

        return $this;
    }

    public function getPartnerSiteReference(): ?string
    {
        return $this->partnerSiteReference;
    }

    public function setPartnerSiteReference(?string $partnerSiteReference): self
    {
        $this->partnerSiteReference = $partnerSiteReference;

        return $this;
    }

    public function getInitialRequestorPartnerSiteReference(): ?string
    {
        return $this->initialRequestorPartnerSiteReference;
    }

    public function setInitialRequestorPartnerSiteReference(?string $initialRequestorPartnerSiteReference): self
    {
        $this->initialRequestorPartnerSiteReference = $initialRequestorPartnerSiteReference;

        return $this;
    }

    public function getInitialRequestorPartnerReference(): ?string
    {
        return $this->initialRequestorPartnerReference;
    }

    public function setInitialRequestorPartnerReference(?string $initialRequestorPartnerReference): self
    {
        $this->initialRequestorPartnerReference = $initialRequestorPartnerReference;

        return $this;
    }

    public function getBrandReference(): string
    {
        return $this->brandReference;
    }

    public function setBrandReference(string $brandReference): self
    {
        $this->brandReference = $brandReference;

        return $this;
    }

    public function getInvoicingCode(): ?string
    {
        return $this->invoicingCode;
    }

    public function setInvoicingCode(?string $invoicingCode): self
    {
        $this->invoicingCode = $invoicingCode;

        return $this;
    }

    public function getInternalNumber(): ?string
    {
        return $this->internalNumber;
    }

    public function setInternalNumber(?string $internalNumber): self
    {
        $this->internalNumber = $internalNumber;

        return $this;
    }

    public function getProductNature(): ?string
    {
        return $this->productNature;
    }

    public function setProductNature(?string $productNature): self
    {
        $this->productNature = $productNature;

        return $this;
    }

    public function getProductReference(): ?string
    {
        return $this->productReference;
    }

    public function setProductReference(?string $productReference): self
    {
        $this->productReference = $productReference;

        return $this;
    }

    public function getProductSerialNumber(): ?string
    {
        return $this->productSerialNumber;
    }

    public function setProductSerialNumber(?string $productSerialNumber): self
    {
        $this->productSerialNumber = $productSerialNumber;

        return $this;
    }

    public function getExternalNumber(): ?string
    {
        return $this->externalNumber;
    }

    public function setExternalNumber(?string $externalNumber): self
    {
        $this->externalNumber = $externalNumber;

        return $this;
    }

    public function getBatchReference(): ?string
    {
        return $this->batchReference;
    }

    public function setBatchReference(?string $batchReference): self
    {
        $this->batchReference = $batchReference;

        return $this;
    }

    public function getMovementSerialNumberReference(): ?string
    {
        return $this->movementSerialNumberReference;
    }

    public function setMovementSerialNumberReference(?string $movementSerialNumberReference): self
    {
        $this->movementSerialNumberReference = $movementSerialNumberReference;

        return $this;
    }

    public function getMovementReference(): ?string
    {
        return $this->movementReference;
    }

    public function setMovementReference(?string $movementReference): self
    {
        $this->movementReference = $movementReference;

        return $this;
    }

    public function getInterventionCode(): ?string
    {
        return $this->interventionCode;
    }

    public function setInterventionCode(?string $interventionCode): self
    {
        $this->interventionCode = $interventionCode;

        return $this;
    }

    public function getProgress(): BusinessDealProgress
    {
        return $this->progress;
    }

    public function setProgress(BusinessDealProgress $progress): self
    {
        $this->progress = $progress;

        return $this;
    }

    public function getAccessCode(): ?string
    {
        return $this->accessCode;
    }

    public function setAccessCode(?string $accessCode): self
    {
        $this->accessCode = $accessCode;

        return $this;
    }

    public function getQuickService(): ?bool
    {
        return $this->quickService;
    }

    public function setQuickService(?bool $quickService): self
    {
        $this->quickService = $quickService;

        return $this;
    }

    public function getInterventionInvoicingCode(): ?string
    {
        return $this->interventionInvoicingCode;
    }

    public function setInterventionInvoicingCode(?string $interventionInvoicingCode): self
    {
        $this->interventionInvoicingCode = $interventionInvoicingCode;

        return $this;
    }
}
