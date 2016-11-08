<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\QuoteModel;

class CommSaleValues extends AbstractValues {

    protected $tenureTypeId;
    protected $propertyPrice;
    protected $noOfSellers;

    protected $isMortgaged;

    public function validate(&$errs) {
        $saleErrs = array();
        if (empty($this->propertyPrice) || $this->propertyPrice < 0) {
            $saleErrs['price'] = "Property price is required";
        }

        if (empty($this->tenureTypeId)) {
            $saleErrs['tenureTypeId'] = "You must select freehold or leasehold.";
        }
        if ($this->noOfSellers <= 0) {
            $saleErrs['noOfBuyers'] = "Must be at least 1 person.";
        }

        if (count($saleErrs)) $errs['commSale'] = $saleErrs;
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
     * @param mixed $noOfBuyers
     */
    public function setNoOfSellers($noOfBuyers) {
        $this->noOfSellers = (int)$noOfBuyers;
    }

    /**
     * @param mixed $isRightToBuy
     */
    public function setIsMortgaged($isRightToBuy) {
        $this->isMortgaged = $isRightToBuy;
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
    public function getNoOfSellers() {
        return $this->noOfSellers;
    }

    /**
     * @return mixed
     */
    public function getIsMortgaged() {
        return $this->isMortgaged;
    }
}