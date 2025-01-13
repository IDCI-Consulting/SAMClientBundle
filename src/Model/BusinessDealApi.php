<?php

namespace IDCI\Bundle\SAMClientBundle\Model;

use IDCI\Bundle\SAMClientBundle\Model\BusinessDealActivityApi;
use IDCI\Bundle\SAMClientBundle\Model\BusinessDealCarrierApi;
use IDCI\Bundle\SAMClientBundle\Model\BusinessDealContactApi;
use IDCI\Bundle\SAMClientBundle\Model\BusinessDealDiagnosticApi;
use IDCI\Bundle\SAMClientBundle\Model\BusinessDealEstimateApi;
use IDCI\Bundle\SAMClientBundle\Model\BusinessDealReceiptApi;
use IDCI\Bundle\SAMClientBundle\Model\CodeText;

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
<<<<<<< HEAD
    private BusinessDealDiagnosticApi $lastDiagnostic;
    private BusinessDealReceiptApi $lastReceipt;
    private BusinessDealEstimateApi $lastEstimate;
    private BusinessDealContactApi $contact;
    private CodeText $handlingCode;
    private CodeText $brandCertification;
    private BusinessDealCarrierApi $outboundCarrier;
=======
    private ?BusinessDealDiagnosticApi $lastDiagnostic;
    private ?BusinessDealReceiptApi $lastReceipt;
    private ?BusinessDealEstimateApi $lastEstimate;
    private ?BusinessDealContactApi $contact;
    private ?CodeText $handlingCode;
    private ?CodeText $brandCertification;
    private ?BusinessDealCarrierApi $outboundCarrier;
>>>>>>> 73e0d5c (Add api call)
    private ?string $initialRequestorPartnerSiteReference;

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
        $this->externelId = $externalId;

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

    public function getInterventionCode(): CodeText
    {
        return $this->interventionCode;
    }

    public function setInterventionCode(CodeText $interventionCode): self
    {
        $this->interventionCode = $interventionCode;

        return $this;
    }

    public function getCompetenceLevel(): CodeText
    {
        return $this->competenceLevel;
    }

    public function setCompetenceLevel(CodeText $competenceLevel): self
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

    public function getProductNature(): CodeText
    {
        return $this->productNature;
    }

    public function setProductNature(CodeText $productNature): self
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

    public function getDefectComponent(): CodeText
    {
        return $this->defectComponent;
    }

    public function setDefectComponent(CodeText $defectComponent): self
    {
        $this->defectComponent = $defectComponent;

        return $this;
    }

    public function getDefectReason(): CodeText
    {
        return $this->defectReason;
    }

    public function setDefectReason(CodeText $defectReason): self
    {
        $this->defectReason = $defectReason;

        return $this;
    }

    public function getCustomerDecision(): CodeText
    {
        return $this->defectReason;
    }

    public function setCustomerDecision(CodeText $customerDecision): self
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

<<<<<<< HEAD
    public getStatus(): string
=======
    public function getStatus(): string
>>>>>>> 73e0d5c (Add api call)
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
<<<<<<< HEAD
        $this->status = $status:
=======
        $this->status = $status;
>>>>>>> 73e0d5c (Add api call)

        return $this;
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

<<<<<<< HEAD
    public function getLastDiagnostic(): BusinessDealDiagnosticApi
=======
    public function getLastDiagnostic(): ?BusinessDealDiagnosticApi
>>>>>>> 73e0d5c (Add api call)
    {
        return $this->lastDiagnostic;
    }

<<<<<<< HEAD
    public function setLastDiagnostic(BusinessDealDiagnosticApi $lastDiagnostic): self
=======
    public function setLastDiagnostic(?BusinessDealDiagnosticApi $lastDiagnostic): self
>>>>>>> 73e0d5c (Add api call)
    {
        $this->lastDiagnostic = $lastDiagnostic;

        return $this;
    }

<<<<<<< HEAD
    public function getLastReceipt(): BusinessDealReceiptApi
=======
    public function getLastReceipt(): ?BusinessDealReceiptApi
>>>>>>> 73e0d5c (Add api call)
    {
        return $this->lastReceipt;
    }

<<<<<<< HEAD
    public function setLastReceipt(BusinessDealReceiptApi $lastReceipt): self
=======
    public function setLastReceipt(?BusinessDealReceiptApi $lastReceipt): self
>>>>>>> 73e0d5c (Add api call)
    {
        $this->lastReceipt = $lastReceipt;

        return $this;
    }

<<<<<<< HEAD
    public function getLastEstimate(): BusinessDealEstimateApi
=======
    public function getLastEstimate(): ?BusinessDealEstimateApi
>>>>>>> 73e0d5c (Add api call)
    {
        return $this->lastEstimate;
    }

<<<<<<< HEAD
    public function setLastEstimate(BusinessDealEstimateApi $lastEstimate): self
=======
    public function setLastEstimate(?BusinessDealEstimateApi $lastEstimate): self
>>>>>>> 73e0d5c (Add api call)
    {
        $this->lastEstimate = $lastEstimate;

        return $this;
    }

<<<<<<< HEAD
    public function getContact(): BusinessDealContactApi
=======
    public function getContact(): ?BusinessDealContactApi
>>>>>>> 73e0d5c (Add api call)
    {
        return $this->contact;
    }

<<<<<<< HEAD
    public function setContact(BusinessDealContactApi $contact): self
=======
    public function setContact(?BusinessDealContactApi $contact): self
>>>>>>> 73e0d5c (Add api call)
    {
        $this->contact = $contact;

        return $this;
    }

<<<<<<< HEAD
    public function getHandlingCode(): CodeText
=======
    public function getHandlingCode(): ?CodeText
>>>>>>> 73e0d5c (Add api call)
    {
        return $this->handlingCode;
    }

<<<<<<< HEAD
    public function setHandlingCode(CodeText $handlingCode): self
=======
    public function setHandlingCode(?CodeText $handlingCode): self
>>>>>>> 73e0d5c (Add api call)
    {
        $this->handlingCode = $handlingCode;

        return $this;
    }

<<<<<<< HEAD
    public function getBrandCertification(): CodeText
=======
    public function getBrandCertification(): ?CodeText
>>>>>>> 73e0d5c (Add api call)
    {
        return $this->brandCertification;
    }

<<<<<<< HEAD
    public function setBrandCertification(CodeText $brandCertification): self
=======
    public function setBrandCertification(?CodeText $brandCertification): self
>>>>>>> 73e0d5c (Add api call)
    {
        $this->brandCertification = $brandCertification;

        return $this;
    }

<<<<<<< HEAD
    public function getOutboundCarrier(): BusinessDealCarrierApi
=======
    public function getOutboundCarrier(): ?BusinessDealCarrierApi
>>>>>>> 73e0d5c (Add api call)
    {
        return $this->outboundCarrier;
    }

<<<<<<< HEAD
    public function setOutboundCarrier(BusinessDealCarrier)
=======
    public function setOutboundCarrier(?BusinessDealCarrier $outboundCarrier): self
    {
        $this->outboundCarrier = $outboundCarrier;

        return $this;
    }
>>>>>>> 73e0d5c (Add api call)

    public function getInitialRequestorPartnerSiteReference(): ?string
    {
        return $this->initialRequestorPartnerSiteReference;
    }

    public function setInitialRequestorPartnerSiteReference(?string $initialRequestorPartnerSiteReference): self
    {
        $this->initialRequestorPartnerSiteReference = $initialRequestorPartnerSiteReference;

        return $this;
    }
}

