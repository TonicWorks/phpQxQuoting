<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\QuoteModel;

class QuoteDetails {

    const TENURE_TYPE_FREEHOLD  = 1;
    const TENURE_TYPE_LEASEHOLD = 2;

    const MORTGAGE_TYPE_REGULAR = 1;
    const MORTGAGE_TYPE_ISLAMIC = 2;

    /** @var int|null */
    protected $sourceWebsiteId;
    /** @var int */
    protected $campaignId;
    /** @var int|null */
    protected $quoteDistributionId;
    /** @var int|null */
    protected $campaignAffiliateId;
    /** @var boolean|null */
    protected $isDuplicate;
    /** @var boolean|null */
    protected $lookingToInstruct;
    /** @var string|null */
    protected $searchLocation;
    /** @var int[]|null */
    protected $alwaysQuoteCompanyIds;
    /** @var int[]|null */
    protected $autoClientInterestCompanyIds;
    /** @var int|null */
    protected $quoteEntryFilterStrategy;


    /** @var ContactDetails */
    protected $contactDetails;

    // CASE SPECIFIC PROPERTIES get stored in their relevant class.
    /**
     * @var PurchaseValues[]|SaleValues[]|RemortgageValues[]|TransferValues[]
     */
    protected $extraDetails = array();

    protected $purchaseValues;
    protected $saleValues;
    protected $remortgageValues;
    protected $transferValues;
    protected $commPurchaseValues;
    protected $commSaleValues;

    protected $scotlandPurchaseValues;
    protected $scotlandSaleValues;
    /**
     * @var string[]
     */
    protected $errors = array();

    public function __construct() {
        $this->contactDetails = new ContactDetails();
    }

    public function buildRequest() {
        $request = [];

        if (!empty($this->sourceWebsiteId)) $request['sourceWebsiteId']  = $this->sourceWebsiteId;
        if (!empty($this->negotiatorUserId)) $request['negotiatorUserId'] = $this->negotiatorUserId;
        if (!empty($this->campaignId)) $request['campaignId'] = $this->campaignId;
        if (!empty($this->campaignAffiliateId)) $request['campaignAffiliateId'] = $this->campaignAffiliateId;
        if (!empty($this->isDuplicate)) $request['isDuplicate'] = $this->isDuplicate;
        if (!empty($this->lookingToInstruct)) $request['lookingToInstruct'] = $this->lookingToInstruct;
        if (!empty($this->searchLocation)) $request['searchLocation'] = $this->searchLocation;
        if (!empty($this->alwaysQuoteCompanyIds)) $request['alwaysQuoteCompanyIds'] = $this->alwaysQuoteCompanyIds;
        if (!empty($this->autoClientInterestCompanyIds)) $request['autoClientInterestCompanyIds'] = $this->autoClientInterestCompanyIds;
        if (!empty($this->quoteEntryFilterStrategy)) $request['quoteEntryFilterStrategy'] = $this->quoteEntryFilterStrategy;
        if ($this->quoteDistributionId !== null) $request['quoteDistributionId'] = $this->quoteDistributionId;

        return $request;
    }

    public function validate() {
        $errs = array();
        $personalErrors = $this->contactDetails->validate();
        if (count($personalErrors)) $errs['personal'] = $personalErrors;

        foreach ($this->extraDetails as $quoteDetails) {
            $quoteDetails->validate($errs);
        }

        $this->errors = $errs;

        return count($errs) == 0;
    }

    public function hasScotlandConveyancing() {
        foreach($this->extraDetails as $values) {
            if ($values instanceof ScotlandPurchaseValues) {
                return true;
            }
            if ($values instanceof ScotlandSaleValues) {
                return true;
            }
        }
        return false;
    }

    public function getTemplateValues() {
        $result = array();

        $result['err'] = $this->errors;

        $result['value'] = array(
            'forename'     => $this->contactDetails->getForename(),
            'surname'      => $this->contactDetails->getSurname(),
            'titleTypeId'  => $this->contactDetails->getTitleType(),
            'emailAddress' => $this->contactDetails->getEmailAddress(),
            'homeTelNo'    => $this->contactDetails->getHomeTelNo()
        );

//        $result['contact_number'] = FrontendModel::getModuleSetting(
//            PrsIntegrationConstants::MODULE_NAME,
//            PrsIntegrationConstants::SETTING_CONTACT_NUMBER,
//            "PHONE NUMBER REQUIRED"
//        );

        return $result;
    }

    /**
     * @return int|null
     */
    public function getSourceWebsiteId() {
        return $this->sourceWebsiteId;
    }

    /**
     * @param int|null $sourceWebsiteId
     * @return QuoteDetails
     */
    public function setSourceWebsiteId($sourceWebsiteId) {
        $this->sourceWebsiteId = $sourceWebsiteId;
        return $this;
    }

    /**
     * @return int
     */
    public function getCampaignId() {
        return $this->campaignId;
    }

    /**
     * @param int $campaignId
     * @return QuoteDetails
     */
    public function setCampaignId($campaignId) {
        $this->campaignId = $campaignId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCampaignAffiliateId() {
        return $this->campaignAffiliateId;
    }

    /**
     * @param int|null $campaignAffiliateId
     * @return QuoteDetails
     */
    public function setCampaignAffiliateId($campaignAffiliateId) {
        $this->campaignAffiliateId = $campaignAffiliateId;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsDuplicate() {
        return $this->isDuplicate;
    }

    /**
     * @param bool|null $isDuplicate
     * @return QuoteDetails
     */
    public function setIsDuplicate($isDuplicate) {
        $this->isDuplicate = $isDuplicate;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getLookingToInstruct() {
        return $this->lookingToInstruct;
    }

    /**
     * @param bool|null $lookingToInstruct
     * @return QuoteDetails
     */
    public function setLookingToInstruct($lookingToInstruct) {
        $this->lookingToInstruct = $lookingToInstruct;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSearchLocation() {
        return $this->searchLocation;
    }

    /**
     * @param null|string $searchLocation
     * @return QuoteDetails
     */
    public function setSearchLocation($searchLocation) {
        $this->searchLocation = $searchLocation;
        return $this;
    }

    /**
     * @return \int[]|null
     */
    public function getAlwaysQuoteCompanyIds() {
        return $this->alwaysQuoteCompanyIds;
    }

    /**
     * @param \int[]|null $alwaysQuoteCompanyIds
     * @return QuoteDetails
     */
    public function setAlwaysQuoteCompanyIds($alwaysQuoteCompanyIds) {
        $this->alwaysQuoteCompanyIds = $alwaysQuoteCompanyIds;
        return $this;
    }

    /**
     * @return \int[]|null
     */
    public function getAutoClientInterestCompanyIds() {
        return $this->autoClientInterestCompanyIds;
    }

    /**
     * @param \int[]|null $autoClientInterestCompanyIds
     * @return QuoteDetails
     */
    public function setAutoClientInterestCompanyIds(
        $autoClientInterestCompanyIds
    ) {
        $this->autoClientInterestCompanyIds = $autoClientInterestCompanyIds;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuoteEntryFilterStrategy() {
        return $this->quoteEntryFilterStrategy;
    }

    /**
     * @param int|null $quoteEntryFilterStrategy
     * @return QuoteDetails
     */
    public function setQuoteEntryFilterStrategy($quoteEntryFilterStrategy) {
        $this->quoteEntryFilterStrategy = $quoteEntryFilterStrategy;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuoteDistributionId() {
        return $this->quoteDistributionId;
    }

    /**
     * @param int|null $quoteDistributionId
     */
    public function setQuoteDistributionId($quoteDistributionId) {
        $this->quoteDistributionId = $quoteDistributionId;
    }


    protected function add($values) {
        $this->extraDetails[] = $values;
    }

    public function addPurchaseValues() {
        $this->purchaseValues = new PurchaseValues();
        $this->add($this->purchaseValues);
        return $this->purchaseValues;
    }

    public function addCommPurchaseValues() {
        $this->commPurchaseValues = new CommPurchaseValues();
        $this->add($this->commPurchaseValues);
        return $this->commPurchaseValues;
    }

    public function addCommSaleValues() {
        $this->commSaleValues = new CommSaleValues();
        $this->add($this->commSaleValues);
        return $this->commSaleValues;
    }

    public function addSaleValues() {
        $this->saleValues = new SaleValues();
        $this->add($this->saleValues);
        return $this->saleValues;
    }

    public function addRemortgageValues() {
        $this->remortgageValues = new RemortgageValues();
        $this->add($this->remortgageValues);
        return $this->remortgageValues;
    }

    public function addTransferValues() {
        $this->transferValues = new TransferValues();
        $this->add($this->transferValues);
        return $this->transferValues;
    }

    public function addScotlandPurchaseValues() {
        $this->scotlandPurchaseValues = new ScotlandPurchaseValues();
        $this->add($this->scotlandPurchaseValues);
        return $this->scotlandPurchaseValues;
    }

    public function addScotlandSaleValues() {
        $this->scotlandSaleValues = new ScotlandSaleValues();
        $this->add($this->scotlandSaleValues);
        return $this->scotlandSaleValues;
    }

    /**
     * @return ContactDetails
     */
    public function getContactDetails() {
        return $this->contactDetails;
    }

    /**
     * @return PurchaseValues[]|RemortgageValues[]|SaleValues[]|TransferValues[]
     */
    public function getExtraDetails() {
        return $this->extraDetails;
    }

    /**
     * @return mixed
     */
    public function getPurchaseValues() {
        return $this->purchaseValues;
    }

    /**
     * @return mixed
     */
    public function getSaleValues() {
        return $this->saleValues;
    }

    /**
     * @return mixed
     */
    public function getRemortgageValues() {
        return $this->remortgageValues;
    }

    /**
     * @return mixed
     */
    public function getTransferValues() {
        return $this->transferValues;
    }

    /**
     * @return mixed
     */
    public function getCommPurchaseValues() {
        return $this->commPurchaseValues;
    }

    /**
     * @return mixed
     */
    public function getCommSaleValues() {
        return $this->commSaleValues;
    }

    /**
     * @return mixed
     */
    public function getScotlandPurchaseValues() {
        return $this->scotlandPurchaseValues;
    }

    /**
     * @return mixed
     */
    public function getScotlandSaleValues() {
        return $this->scotlandSaleValues;
    }
}

