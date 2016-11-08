<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\Integration\Rest;

interface InstructQuoteDetails {
    public function hasSecondQuote();

    public function getNoPeople($quoteId);

    public function getLeadForename($quoteId);

    public function getLeadSurname($quoteId);

    public function getLeadContactNo($quoteId);

    public function getLeadEmail($quoteId);

    public function getFirstQuoteId();

    public function getSecondQuoteId();

    public function getFirstQuoteHash();

    public function getSecondQuoteHash();


}
 