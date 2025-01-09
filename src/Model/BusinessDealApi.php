<?php

namespace IDCI\Bundle\SAMClientBundle\Model;

use IDCI\Bundle\SAMClientBundle\Model\BusinessDealActivityApi;
use IDCI\Bundle\SAMClientBundle\Model\BusinessDealCarrierApi;
use IDCI\Bundle\SAMClientBundle\Model\BusinessDealContactApi;
use IDCI\Bundle\SAMClientBundle\Model\BusinessDealDiagnosticApi;
use IDCI\Bundle\SAMClientBundle\Model\BusinessDealEstimateApi;
use IDCI\Bundle\SAMClientBundle\Model\BusinessDealReceiptApi;

class BusinessDealApi
{
    private int $id;
    private ?string $internalNumber;
    private ?string $externalId;
    private CodeText $invoicingCode;
    private CodeText $interventionCode;
    private CodeText $competenceLevel;
    private ?string $brandReference;
    private ?string $productReference;
    private ?string $productSerialNumber;
    private CodeText $productNature;
    private ?string $batchReference;
    private ?string $movementSerialNumberReference;
    private ?string $movementReference;
    private ?string $partnerReference;
    private CodeText $defectComponent;
    private CodeText $defectReason;
    private CodeText $customerDecision;
    private ?string $expectedDelivery;
    private ?string $expectedWorkshop;
    private ?string $accessCode;
    private string $status;
    private ?array $businessDealActivities;
    private BusinessDealActivityApi $lastBusinessDealActivity;
    private BusinessDealDiagnosticApi $lastDiagnostic;
    private BusinessDealReceiptApi $lastReceipt;
    private BusinessDealEstimateApi $lastEstimate;
    private BusinessDealContactApi $contact;
    private CodeText $handlingCode;
    private CodeText $brandCertification;
    private BusinessDealCarrierApi $outboundCarrier;
    private ?string $initialRequestorPartnerSiteReference;

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function setExternalId(string $externalId): self
    {
        $this->externelId = $externalId;

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

    public function getInitialRequestorPartnerSiteReference(): ?string
    {
        return $this->initialRequestorPartnerSiteReference;
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

    public function getAccessCode(): ?string
    {
        return $this->accessCode;
    }

    public function setAccessCode(?string $accessCode): self
    {
        $this->accessCode = $accessCode;

        return $this;
    }
}

