<?php
/**
 * @copyright Totem Media (c) 2012/13/14 
 */

namespace TonicWorks\Quotexpress\Summariser\Summary;
 
class QuoteInstructInputs {
    /** @var int */
    protected $firstQuoteId;
    /** @var int */
    protected $secondQuoteId;
    /** @var  QuoteInstructLeadContact */
    protected $leadContact;
    /** @var string */
    protected $hash;
    /** @var int */
    protected $firstQuoteNoPeople;
    /** @var int */
    protected $secondQuoteNoPeople;
    /** @var bool */
    protected $hasServiceFee;
    /** @var string */
    protected $quoteInstructLink;

    function __construct($firstQuoteId, $secondQuoteId, $leadContact, $hash, $firstQuoteNoPeople, $secondQuoteNoPeople, $hasServiceFee, $quoteInstructLink) {
        $this->firstQuoteId  = $firstQuoteId;
        $this->secondQuoteId = $secondQuoteId;
        $this->leadContact = $leadContact;
        $this->hash = $hash;
        $this->firstQuoteNoPeople = $firstQuoteNoPeople;
        $this->secondQuoteNoPeople = $secondQuoteNoPeople;
        $this->hasServiceFee = $hasServiceFee;
        $this->quoteInstructLink = $quoteInstructLink;
    }

    /**
     * @return int
     */
    public function getFirstQuoteId() {
        return $this->firstQuoteId;
    }

    /**
     * @return int
     */
    public function getSecondQuoteId() {
        return $this->secondQuoteId;
    }

    /**
     * @return \TonicWorks\Quotexpress\Summariser\Summary\QuoteInstructLeadContact
     */
    public function getLeadContact() {
        return $this->leadContact;
    }

    public function hasSecondQuote() {
        return !empty($this->secondQuoteId);
    }

    /**
     * @return string
     */
    public function getHash() {
        return $this->hash;
    }

    /**
     * @return int
     */
    public function getFirstQuoteNoPeople() {
        return $this->firstQuoteNoPeople;
    }

    /**
     * @return int
     */
    public function getSecondQuoteNoPeople() {
        return $this->secondQuoteNoPeople;
    }

    /**
     * @return boolean
     */
    public function getHasServiceFee() {
        return $this->hasServiceFee;
    }

    /**
     * @return string
     */
    public function getQuoteInstructLink() {
        return $this->quoteInstructLink;
    }

}
 