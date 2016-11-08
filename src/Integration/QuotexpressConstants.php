<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\Integration;

class QuotexpressConstants {
    const WORK_TYPE_PURCHASE   = 1;
    const WORK_TYPE_SALE       = 2;
    const WORK_TYPE_TRANSFER   = 3;
    const WORK_TYPE_REMORTGAGE = 4;

    const WORK_TYPE_SCOTLAND_PURCHASE   = 51;
    const WORK_TYPE_SCOTLAND_SALE       = 52;

    const WORK_TYPE_COMM_PURCHASE = 101;
    const WORK_TYPE_COMM_SALE     = 102;

    // Not actually WorkTypeIds - we just need a value to represent combined
    // cases locally.
    const COMBINED_TRANSFER_REMO = 1000000;
    const COMBINED_SALE_PURCHASE = 1000001;

    const FEE_CATEGORY_LEGAL_FEES_ID       = 1;
    const FEE_CATEGORY_ADDITIONAL_COSTS_ID = 2;
    const FEE_CATEGORY_DISBURSEMENTS_ID    = 3;
    const FEE_CATEGORY_SERVICE_FEES_ID     = 1000;

    const STATUS_CREATED              = 1;
    const STATUS_INSTRUCTED           = 3;
    const STATUS_PARTIALLY_INSTRUCTED = 5;

    const NOTIFICATION_CONTEXT_QUOTE = 501;

    public static function getTitles() {
        return array('Mr' => 'Mr', 'Mrs' => 'Mrs', 'Miss' => 'Miss', 'Ms' => 'Ms', 'Dr' => 'Dr');
    }

}