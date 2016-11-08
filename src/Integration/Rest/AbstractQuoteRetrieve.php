<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\Integration\Rest;

abstract class AbstractQuoteRetrieve {

    /** @return array[] */
    abstract protected function getFirstLeadSummary();
    /** @return array[] */
    abstract protected function getSecondLeadSummary();

    /** @return boolean */
    abstract protected function isCombinedQuote();

    /** @return string */
    abstract protected function getFirstLeadCaseTypeFlag();
    /** @return boolean */
    abstract protected function isSearchPackRelevant();

    /** @return boolean */
    abstract protected function isSalePurchase();

    abstract protected function populateSystemSpecific($baseInstructUrl, &$vars);


}
 