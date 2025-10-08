<?php

namespace IDCI\Bundle\SAMClientBundle\Model;

use IDCI\Bundle\SAMClientBundle\Model\BusinessDealActivityApi;
use IDCI\Bundle\SAMClientBundle\Model\BusinessDealCarrierApi;
use IDCI\Bundle\SAMClientBundle\Model\BusinessDealContactApi;
use IDCI\Bundle\SAMClientBundle\Model\BusinessDealDiagnosticApi;
use IDCI\Bundle\SAMClientBundle\Model\BusinessDealEstimateApi;
use IDCI\Bundle\SAMClientBundle\Model\BusinessDealOrderApi;
use IDCI\Bundle\SAMClientBundle\Model\BusinessDealReceiptApi;
use IDCI\Bundle\SAMClientBundle\Model\BusinessDealWorkReportApi;
use IDCI\Bundle\SAMClientBundle\Model\CodeText;
use IDCI\Bundle\SAMClientBundle\Model\Enum\BusinessDealApiStatus;

class BusinessDealApi
{
    private int $id;
    private ?string $internalNumber = null;
    private ?string $externalId = null;
    private CodeText $invoicingCode;
    private ?CodeText $interventionCode = null;
    private ?CodeText $competenceLevel = null;
    private ?string $brandReference = null;
    private ?string $productReference = null;
    private ?string $productSerialNumber = null;
    private ?CodeText $productNature = null;
    private ?string $batchReference = null;
    private ?string $movementSerialNumberReference = null;
    private ?string $movementReference = null;
    private ?string $partnerReference = null;
    private ?string $externalNumber = null;
    private ?CodeText $defectComponent = null;
    private ?CodeText $defectReason = null;
    private ?CodeText $customerDecision = null;
    private ?string $expectedDelivery = null;
    private ?string $expectedWorkshop = null;
    private ?string $accessCode = null;
    private BusinessDealApiStatus $status;
    private ?array $businessDealActivities = null;
    private BusinessDealActivityApi $lastBusinessDealActivity;
    private ?BusinessDealDiagnosticApi $lastDiagnostic = null;
    private ?BusinessDealReceiptApi $lastReceipt = null;
    private ?BusinessDealEstimateApi $lastEstimate = null;
    private ?BusinessDealOrderApi $lastOrder = null;
    private ?BusinessDealWorkReportApi $lastWorkReport = null;
    private ?BusinessDealContactApi $contact = null;
    private ?CodeText $handlingCode = null;
    private ?CodeText $brandCertification = null;
    private ?BusinessDealCarrierApi $outboundCarrier = null;
    private ?string $initialRequestorPartnerSiteReference = null;
    private ?bool $quickService = null;
    private ?CodeText $interventionInvoicingCode = null;

    public function __construct(?array $businessDealActivities)
    {
        $this->businessDealActivities = $businessDealActivities;
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

    public function getInternalNumber(): ?string
    {
        return $this->internalNumber;
    }

    public function setInternalNumber(?string $internalNumber): self
    {
        $this->internalNumber = $internalNumber;

        return $this;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setExternalId(?string $externalId): self
    {
        $this->externalId = $externalId;

        return $this;
    }

    public function getInvoicingCode(): CodeText
    {
        return $this->invoicingCode;
    }

    public function setInvoicingCode(CodeText $invoicingCode): self
    {
        $this->invoicingCode = $invoicingCode;

        return $this;
    }

    public function getInterventionCode(): ?CodeText
    {
        return $this->interventionCode;
    }

    public function setInterventionCode(?CodeText $interventionCode): self
    {
        $this->interventionCode = $interventionCode;

        return $this;
    }

    public function getCompetenceLevel(): ?CodeText
    {
        return $this->competenceLevel;
    }

    public function setCompetenceLevel(?CodeText $competenceLevel): self
    {
        $this->competenceLevel = $competenceLevel;

        return $this;
    }

    public function getBrandReference(): ?string
    {
        return $this->brandReference;
    }

    public function setBrandReference(?string $brandReference): self
    {
        $this->brandReference = $brandReference;

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

    public function getProductNature(): ?CodeText
    {
        return $this->productNature;
    }

    public function setProductNature(?CodeText $productNature): self
    {
        $this->productNature = $productNature;

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

    public function getPartnerReference(): ?string
    {
        return $this->partnerReference;
    }

    public function setPartnerReference(?string $partnerReference): self
    {
        $this->partnerReference = $partnerReference;

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

    public function getDefectComponent(): ?CodeText
    {
        return $this->defectComponent;
    }

    public function setDefectComponent(?CodeText $defectComponent): self
    {
        $this->defectComponent = $defectComponent;

        return $this;
    }

    public function getDefectReason(): ?CodeText
    {
        return $this->defectReason;
    }

    public function setDefectReason(?CodeText $defectReason): self
    {
        $this->defectReason = $defectReason;

        return $this;
    }

    public function getCustomerDecision(): ?CodeText
    {
        return $this->customerDecision;
    }

    public function setCustomerDecision(?CodeText $customerDecision): self
    {
        $this->customerDecision = $customerDecision;

        return $this;
    }

    public function getExpectedDelivery(): ?string
    {
        return $this->expectedDelivery;
    }

    public function setExpectedDelivery(?string $expectedDelivery): self
    {
        $this->expectedDelivery = $expectedDelivery;

        return $this;
    }

    public function getExpectedWorkshop(): ?string
    {
        return $this->expectedWorkshop;
    }

    public function setExpectedWorkshop(?string $expectedWorkshop): self
    {
        $this->expectedWorkshop = $expectedWorkshop;

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

    public function getStatus(): BusinessDealApiStatus
    {
        return $this->status;
    }

    public function setStatus(BusinessDealApiStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getBusinessDealActivities(): ?array
    {
        return $this->businessDealActivities;
    }

    public function getLastBusinessDealActivity(): BusinessDealActivityApi
    {
        return $this->lastBusinessDealActivity;
    }

    public function setLastBusinessDealActivity(BusinessDealActivityApi $lastBusinessDealActivity): self
    {
        $this->lastBusinessDealActivity = $lastBusinessDealActivity;

        return $this;
    }

    public function getLastDiagnostic(): ?BusinessDealDiagnosticApi
    {
        return $this->lastDiagnostic;
    }

    public function setLastDiagnostic(?BusinessDealDiagnosticApi $lastDiagnostic): self
    {
        $this->lastDiagnostic = $lastDiagnostic;

        return $this;
    }

    public function getLastReceipt(): ?BusinessDealReceiptApi
    {
        return $this->lastReceipt;
    }

    public function setLastReceipt(?BusinessDealReceiptApi $lastReceipt): self
    {
        $this->lastReceipt = $lastReceipt;

        return $this;
    }

    public function getLastEstimate(): ?BusinessDealEstimateApi
    {
        return $this->lastEstimate;
    }

    public function setLastEstimate(?BusinessDealEstimateApi $lastEstimate): self
    {
        $this->lastEstimate = $lastEstimate;

        return $this;
    }

    public function getLastOrder(): ?BusinessDealOrderApi
    {
        return $this->lastOrder;
    }

    public function setLastOrder(?BusinessDealOrderApi $lastOrder): self
    {
        $this->lastOrder = $lastOrder;

        return $this;
    }

    public function getLastWorkReport(): ?BusinessDealWorkReportApi
    {
        return $this->lastWorkReport;
    }

    public function setLastWorkReport(?BusinessDealWorkReportApi $lastWorkReport): self
    {
        $this->lastWorkReport = $lastWorkReport;

        return $this;
    }

    public function getContact(): ?BusinessDealContactApi
    {
        return $this->contact;
    }

    public function setContact(?BusinessDealContactApi $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getHandlingCode(): ?CodeText
    {
        return $this->handlingCode;
    }

    public function setHandlingCode(?CodeText $handlingCode): self
    {
        $this->handlingCode = $handlingCode;

        return $this;
    }

    public function getBrandCertification(): ?CodeText
    {
        return $this->brandCertification;
    }

    public function setBrandCertification(?CodeText $brandCertification): self
    {
        $this->brandCertification = $brandCertification;

        return $this;
    }

    public function getOutboundCarrier(): ?BusinessDealCarrierApi
    {
        return $this->outboundCarrier;
    }

    public function setOutboundCarrier(?BusinessDealCarrierApi $outboundCarrier): self
    {
        $this->outboundCarrier = $outboundCarrier;

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

    public function getQuickService(): ?bool
    {
        return $this->quickService;
    }

    public function setQuickService(?bool $quickService): self
    {
        $this->quickService = $quickService;

        return $this;
    }

    public function getInterventionInvoicingCode(): ?CodeText
    {
        return $this->interventionInvoicingCode;
    }

    public function setInterventionInvoicingCode(?CodeText $interventionInvoicingCode): self
    {
        $this->interventionInvoicingCode = $interventionInvoicingCode;

        return $this;
    }
}
