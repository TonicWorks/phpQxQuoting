<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\Integration\Rest\Instruct;

abstract class AbstractInstruct {
    abstract public function instruct(QuoteInstructDetails $firstQuote, QuoteInstructDetails $secondQuote = null);
    abstract public function getInstructedUrls();
}

