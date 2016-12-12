<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\QuoteModel;
 
class SaleValues extends AbstractValues {

    protected $tenureTypeId;
    protected $propertyPrice;
    protected $mortgageTypeId;
    protected $noOfSellers;
    protected $isSharedOwnership;
    protected $isUnregistered;
    protected $isFlat;
    protected $isHelpToMortgage;
    protected $isHelpToLoan;
    protected $isNewBuyScheme;
    protected $isAgreed;
    /** @var boolean */
    private $isAuction;

    public function validate(&$errs) {
        $saleErrs = array();

        if ($this->propertyPrice < 1000) {
            $saleErrs['price'] = "Sale price must be over &pound;1000. Did you mean &pound;" . ($this->propertyPrice * 1000) . "?";
        }

        if (empty($this->propertyPrice) || $this->propertyPrice < 0) {
            $saleErrs['price'] = "Sale price is required";
        }

        if (empty($this->tenureTypeId)) {
            $saleErrs['tenureTypeId'] = "You must select freehold or leasehold.";
        }
        if (!in_array($this->mortgageTypeId, array(
            QuoteDetails::MORTGAGE_TYPE_ISLAMIC,
            QuoteDetails::MORTGAGE_TYPE_REGULAR,
            0), true)
        ) {
            $saleErrs['mortgageTypeId'] = "You must select a mortgage type, or 'No Mortgage'.";
        }
        if ($this->noOfSellers <= 0) {
            $saleErrs['noOfBuyers'] = "Must be at least 1 person.";
        }

        if (count($saleErrs)) $errs['sale'] = $saleErrs;
    }

    /**
     * @param mixed $propertyPrice
     */
    public function setPropertyPrice($propertyPrice) {
        $this->propertyPrice = (int)$propertyPrice;
        if ($this->propertyPrice == 0) $this->propertyPrice = '';
    }

    /**
     * @param mixed $tenureTypeId
     */
    public function setTenureTypeId($tenureTypeId) {
        $this->tenureTypeId = (int)$tenureTypeId;
    }

    /**
     * @param mixed $mortgageTypeId
     */
    public function setMortgageTypeId($mortgageTypeId) {
        $this->mortgageTypeId = (int)$mortgageTypeId;
    }

    /**
     * @param mixed $noOfBuyers
     */
    public function setNoOfSellers($noOfBuyers) {
        $this->noOfSellers = (int)$noOfBuyers;
    }

    /**
     * @param mixed $isSharedOwnership
     */
    public function setIsSharedOwnership($isSharedOwnership) {
        $this->isSharedOwnership = $isSharedOwnership;
    }

    /**
     * @param mixed $isUnregistered
     */
    public function setIsUnregistered($isUnregistered) {
        $this->isUnregistered = $isUnregistered;
    }

    /**
     * @return mixed
     */
    public function getIsSharedOwnership()
    {
        return $this->isSharedOwnership;
    }

    /**
     * @return mixed
     */
    public function getIsUnregistered()
    {
        return $this->isUnregistered;
    }

    /**
     * @return mixed
     */
    public function getIsFlat() {
        return $this->isFlat;
    }

    /**
     * @param mixed $isFlat
     */
    public function setIsFlat($isFlat) {
        $this->isFlat = $isFlat;
    }

    /**
     * @return mixed
     */
    public function getTenureTypeId() {
        return $this->tenureTypeId;
    }

    /**
     * @return mixed
     */
    public function getPropertyPrice() {
        return $this->propertyPrice;
    }

    /**
     * @return mixed
     */
    public function getMortgageTypeId() {
        return $this->mortgageTypeId;
    }

    /**
     * @return mixed
     */
    public function getNoOfSellers() {
        return $this->noOfSellers;
    }

    /**
     * @return mixed
     */
    public function getIsHelpToMortgage() {
        return $this->isHelpToMortgage;
    }

    /**
     * @param mixed $isHelpToMortgage
     */
    public function setIsHelpToMortgage($isHelpToMortgage) {
        $this->isHelpToMortgage = $isHelpToMortgage;
    }

    /**
     * @return mixed
     */
    public function getIsHelpToLoan() {
        return $this->isHelpToLoan;
    }

    /**
     * @param mixed $isHelpToLoan
     */
    public function setIsHelpToLoan($isHelpToLoan) {
        $this->isHelpToLoan = $isHelpToLoan;
    }

    /**
     * @return mixed
     */
    public function getIsNewBuyScheme() {
        return $this->isNewBuyScheme;
    }

    /**
     * @param mixed $isNewBuyScheme
     */
    public function setIsNewBuyScheme($isNewBuyScheme) {
        $this->isNewBuyScheme = $isNewBuyScheme;
    }

    /**
     * @return mixed
     */
    public function getIsAgreed() {
        return $this->isAgreed;
    }

    /**
     * @param mixed $isAgreed
     */
    public function setIsAgreed($isAgreed) {
        $this->isAgreed = $isAgreed;
    }

    /**
     * @return bool
     */
    public function getIsAuction() {
        return $this->isAuction;
    }

    /**
     * @param bool $isAuction
     * @return SaleValues
     */
    public function setIsAuction($isAuction) {
        $this->isAuction = $isAuction;
        return $this;
    }
}


