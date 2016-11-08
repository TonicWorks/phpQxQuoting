<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\QuoteModel;

class AbstractValues {
    /** @var array[]|null */
    protected $feeScaleId;
    /** @var int[]|null */
    protected $companyIds;

    /**
     * @return mixed
     */
    public function getFeeScaleId() {
        return $this->feeScaleId;
    }

    /**
     * @param mixed $feeScaleId
     */
    public function setFeeScaleId($feeScaleId) {
        $this->feeScaleId = $feeScaleId;
    }

    /**
     * @return mixed
     */
    public function getCompanyIds() {
        return $this->companyIds;
    }

    /**
     * @param mixed $companyIds
     */
    public function setCompanyIds($companyIds) {
        $this->companyIds = $companyIds;
    }
}

