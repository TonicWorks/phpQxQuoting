<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\QuoteModel;

class CommPurchaseValues extends AbstractValues {

    protected $tenureTypeId;
    protected $propertyPrice;
    protected $noOfBuyers;

    protected $isMortgaged;

    public function validate(&$errs) {
        $purchaseErrs = array();
        if (empty($this->propertyPrice) || $this->propertyPrice < 0) {
            $purchaseErrs['price'] = "Property price is required";
        }

        if (empty($this->tenureTypeId)) {
            $purchaseErrs['tenureTypeId'] = "You must select freehold or leasehold.";
        }
        if ($this->noOfBuyers <= 0) {
            $purchaseErrs['noOfBuyers'] = "Must be at least 1 person.";
        }

        if (count($purchaseErrs)) $errs['commPurchase'] = $purchaseErrs;
    }

    /**
     * @param $request array
     */
    public function buildRequest() {
        $result = array(
            'comm_purchase_tenure_type_id' => $this->tenureTypeId,
            'comm_purchase_price'          => $this->propertyPrice,
            'comm_no_of_buyers'            => $this->noOfBuyers,
        );

        if ($this->isMortgaged) {
            $result['comm_purchase_mortgage'] = 1;
        }

        return $result;
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
    public function setNoOfBuyers($noOfBuyers) {
        $this->noOfBuyers = (int)$noOfBuyers;
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
    public function getNoOfBuyers() {
        return $this->noOfBuyers;
    }

    /**
     * @return mixed
     */
    public function getIsMortgaged() {
        return $this->isMortgaged;
    }
}


 