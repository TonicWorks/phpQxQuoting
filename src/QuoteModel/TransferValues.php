<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\QuoteModel;

class TransferValues extends AbstractValues {

    protected $tenureTypeId;
    protected $mortgageValue;
    protected $transferPrice;
    protected $moneyChangingHands;
    protected $noOfPeople;
    protected $percentage;
    protected $isBuyToLet;

    public function validate(&$errs) {
        $thisErrs = array();
        if ($this->mortgageValue < 0) {
            $thisErrs['mortgageValue'] = "Current mortgage value cannot be negative.";
        }

        if (empty($this->transferPrice) || $this->transferPrice < 0) {
            $thisErrs['price'] = "Transfer price cannot be empty.";
        }

        if ($this->moneyChangingHands < 0) {
            $thisErrs['moneyChangingHands'] = "Amount of money changing hands is required.";
        }

        if (empty($this->tenureTypeId)) {
            $thisErrs['tenureTypeId'] = "You must select freehold or leasehold.";
        }
        if ($this->noOfPeople <= 0) {
            $thisErrs['noOfPeople'] = "Must be at least 1 person.";
        }

        if ($this->percentage <= 0) {
            $thisErrs['percentage'] = "Must transfer at least 1%";
        }

        if (count($thisErrs)) $errs['transfer'] = $thisErrs;
    }

    /**
     * @param mixed $tenureTypeId
     * @return TransferValues
     */
    public function setTenureTypeId($tenureTypeId) {
        $this->tenureTypeId = $tenureTypeId;
        return $this;
    }

    /**
     * @param mixed $mortgageValue
     * @return TransferValues
     */
    public function setMortgageValue($mortgageValue) {
        $this->mortgageValue = $mortgageValue;
        return $this;
    }

    /**
     * @param mixed $transferPrice
     * @return TransferValues
     */
    public function setTransferPrice($transferPrice) {
        $this->transferPrice = $transferPrice;
        return $this;
    }

    /**
     * @param mixed $moneyChangingHands
     * @return TransferValues
     */
    public function setMoneyChangingHands($moneyChangingHands) {
        $this->moneyChangingHands = $moneyChangingHands;
        return $this;
    }

    /**
     * @param mixed $noOfPeople
     * @return TransferValues
     */
    public function setNoOfPeople($noOfPeople) {
        $this->noOfPeople = $noOfPeople;
        return $this;
    }

    /**
     * @param mixed $percentage
     * @return TransferValues
     */
    public function setPercentage($percentage) {
        $this->percentage = $percentage;
        return $this;
    }

    /**
     * @param mixed $isBuyToLet
     * @return TransferValues
     */
    public function setIsBuyToLet($isBuyToLet) {
        $this->isBuyToLet = $isBuyToLet;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMortgageValue()
    {
        return $this->mortgageValue;
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
    public function getTransferPrice() {
        return $this->transferPrice;
    }

    /**
     * @return mixed
     */
    public function getMoneyChangingHands() {
        return $this->moneyChangingHands;
    }

    /**
     * @return mixed
     */
    public function getNoOfPeople() {
        return $this->noOfPeople;
    }

    /**
     * @return mixed
     */
    public function getPercentage() {
        return $this->percentage;
    }

    /**
     * @return mixed
     */
    public function getIsBuyToLet() {
        return $this->isBuyToLet;
    }
}