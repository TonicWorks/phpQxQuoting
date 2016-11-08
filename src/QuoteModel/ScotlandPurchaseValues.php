<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\QuoteModel;

class ScotlandPurchaseValues extends AbstractValues {

    protected $propertyPrice;
    protected $mortgageTypeId;
    protected $noOfBuyers;

    protected $isBuyToLet;
    protected $isNewbuild;
    protected $isUnregistered;

    protected $isHelpToMortgage;
    protected $isHelpToIsa;

    public function validate(&$errs) {
        $purchaseErrs = array();

        if ($this->propertyPrice < 1000) {
            $purchaseErrs['price'] = "Purchase price must be over &pound;1000. Did you mean &pound;" . ($this->propertyPrice * 1000) . "?";
        }

        if (empty($this->propertyPrice) || $this->propertyPrice < 0) {
            $purchaseErrs['price'] = "Purchase price is required";
        }

        if (!in_array($this->mortgageTypeId, array(
            QuoteDetails::MORTGAGE_TYPE_ISLAMIC,
            QuoteDetails::MORTGAGE_TYPE_REGULAR,
            0), true)
        ) {
            $purchaseErrs['mortgageTypeId'] = "You must select a mortgage type, or 'No Mortgage'.";
        }
        if ($this->noOfBuyers <= 0) {
            $purchaseErrs['noOfBuyers'] = "Must be at least 1 person.";
        }

        if (count($purchaseErrs)) $errs['purchase'] = $purchaseErrs;
    }

    /**
     * @param mixed $propertyPrice
     */
    public function setPropertyPrice($propertyPrice) {
        $this->propertyPrice = (int)$propertyPrice;
        if ($this->propertyPrice == 0) $this->propertyPrice = '';
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
    public function setNoOfBuyers($noOfBuyers) {
        $this->noOfBuyers = (int)$noOfBuyers;
    }

    /**
     * @param mixed $isBuyToLet
     */
    public function setIsBuyToLet($isBuyToLet) {
        $this->isBuyToLet = $isBuyToLet;
    }

    /**
     * @param mixed $isNewbuild
     */
    public function setIsNewbuild($isNewbuild) {
        $this->isNewbuild = $isNewbuild;
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
    public function getIsNewbuild()
    {
        return $this->isNewbuild;
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
    public function getIsBuyToLet()
    {
        return $this->isBuyToLet;
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
    public function getNoOfBuyers() {
        return $this->noOfBuyers;
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
    public function getIsHelpToIsa()
    {
        return $this->isHelpToIsa;
    }

    /**
     * @param mixed $isHelpToIsa
     */
    public function setIsHelpToIsa($isHelpToIsa)
    {
        $this->isHelpToIsa = $isHelpToIsa;
    }
}
