<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\QuoteModel;
 
class ScotlandSaleValues extends AbstractValues {

    protected $propertyPrice;
    protected $mortgageTypeId;
    protected $noOfSellers;

    protected $isHelpToMortgage;

    public function validate(&$errs) {
        $saleErrs = array();

        if ($this->propertyPrice < 1000) {
            $saleErrs['price'] = "Sale price must be over &pound;1000. Did you mean &pound;" . ($this->propertyPrice * 1000) . "?";
        }

        if (empty($this->propertyPrice) || $this->propertyPrice < 0) {
            $saleErrs['price'] = "Sale price is required";
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

}


