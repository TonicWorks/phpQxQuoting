<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\QuoteModel;

class RemortgageValues extends AbstractValues {

    protected $tenureTypeId;
    protected $amountBorrowed;
    protected $noOfOwners;
    protected $isBuyToLet;

    public function validate(&$errs) {
        $thisErrs = array();

        if ($this->amountBorrowed < 1000) {
            $thisErrs['amount'] = "Amount being borrowed must be over &pound;1000. Did you mean &pound;" . ($this->amountBorrowed * 1000) . "?";
        }

        if (empty($this->amountBorrowed) || $this->amountBorrowed < 0) {
            $thisErrs['amount'] = "Amount being borrowed is required";
        }

        if (empty($this->tenureTypeId)) {
            $thisErrs['tenureTypeId'] = "You must select freehold or leasehold.";
        }
        if ($this->noOfOwners <= 0) {
            $thisErrs['noOfOwners'] = "Must be at least 1 person.";
        }

        if (count($thisErrs)) $errs['remortgage'] = $thisErrs;
    }

    /**
     * @param mixed $propertyPrice
     */
    public function setAmountBorrowed($propertyPrice) {
        $this->amountBorrowed = (int)$propertyPrice;
        if ($this->amountBorrowed == 0) $this->amountBorrowed = '';
    }

    /**
     * @param mixed $tenureTypeId
     */
    public function setTenureTypeId($tenureTypeId) {
        $this->tenureTypeId = (int)$tenureTypeId;
    }

    /**
     * @param mixed $noOfOwners
     */
    public function setNoOfOwners($noOfOwners) {
        $this->noOfOwners = (int)$noOfOwners;
    }

    /**
     * @param mixed $isBuyToLet
     */
    public function setIsBuyToLet($isBuyToLet) {
        $this->isBuyToLet = $isBuyToLet;
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
    public function getAmountBorrowed() {
        return $this->amountBorrowed;
    }

    /**
     * @return mixed
     */
    public function getNoOfOwners() {
        return $this->noOfOwners;
    }

    /**
     * @return mixed
     */
    public function getIsBuyToLet() {
        return $this->isBuyToLet;
    }
}



