<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\Summariser;
 
interface QuoteSummariserInterface {
    /**
     * @return string
     */
    public function getName();

    /**
     * @param $raw
     * @param $unwrapQuote
     * @return array|object
     */
    public function summariseQuote($raw, $unwrapQuote);
}
 