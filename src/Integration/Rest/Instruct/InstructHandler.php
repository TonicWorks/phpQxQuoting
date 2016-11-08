<?php

namespace TonicWorks\Quotexpress\Integration\Rest\Instruct;

use TonicWorks\Quotexpress\Integration\Rest\QuotexpressQuoteRetrieve;
use TonicWorks\Quotexpress\Summariser\Summary\QuoteInstructInputs;

/**
 * Class InstructHandler
 *
 * Instruction relies on client-side validation to ensure
 * all fields get nice error messages in the UI.
 *
 * It still does some tests to make sure everything is present, but doesn't
 * generate errors for the UI.
 *
 */
class InstructHandler {
    const STATE_PROCESS_SAVED_DETAILS     = 1;
    const STATE_PROCESS_SHOW_SECOND_FORM  = 2;
    const STATE_PROCESS_SHOW_CONFIRM_PAGE = 3;

    const STATE_INSTRUCT_SUCCESS = 201;
    const STATE_INSTRUCT_FAILURE = 202;

    protected $firstQuoteId;
    protected $secondQuoteId;
    //protected $hash;

    const SESSION_VAR = 'qxInstruct';

    /** @var QuoteInstructInputs */
    protected $quoteApiDetails;

    /** @var QuoteInstructDetails */
    protected $firstQuoteInstruct;
    /** @var QuoteInstructDetails */
    protected $secondQuoteInstruct;

    public function __construct(QuotexpressQuoteRetrieve $quote) {
        $quote = $quote->getVariables('instruct');
        /** @var QuoteInstructInputs $quote */
        $this->quoteApiDetails = $quote;
        $this->firstQuoteId    = $quote->getFirstQuoteId();

        if ($this->quoteApiDetails->hasSecondQuote()) {
            $this->secondQuoteId = $this->quoteApiDetails->getSecondQuoteId();
        }

        $qxInstruct = @unserialize(\SpoonSession::get(self::SESSION_VAR));

        if (!empty($qxInstruct)) {
            $this->firstQuoteInstruct = $qxInstruct['first'];
            if ($this->quoteApiDetails->hasSecondQuote()) {
                $this->secondQuoteInstruct = $qxInstruct['second'];
            }
        }

        if (empty($this->firstQuoteInstruct) || $this->firstQuoteInstruct->getQuoteId() != $quote->getFirstQuoteId()) {
            $this->firstQuoteInstruct = new QuoteInstructDetails($this->quoteApiDetails, $quote->getFirstQuoteId(), $quote->getHash(), $quote->getFirstQuoteNoPeople());
            if ($this->quoteApiDetails->hasSecondQuote()) {
                $this->secondQuoteInstruct = new QuoteInstructDetails($this->quoteApiDetails, $quote->getSecondQuoteId(), $quote->getHash(), $quote->getSecondQuoteNoPeople());
            } else {
                $this->secondQuoteInstruct = null;;
            }
        }
    }

    public function save() {
        \SpoonSession::set(self::SESSION_VAR, serialize(array(
            'first' => $this->firstQuoteInstruct,
            'second' => $this->secondQuoteInstruct,
        )));
    }

    public function process($values) {
        $this->save();

        if ($this->quoteApiDetails->hasSecondQuote()) {
            // could be in the first or second form - so check.

            // they must be entering either first or second details, cache them.
            $keys            = array_keys($values['case']);
            $submittedLeadId = reset($keys);
            if ($submittedLeadId == $this->firstQuoteId) {
                // the first case then. stash the details and let them continue to the second form.
                $_SESSION['case'] = $values['case'];
                return self::STATE_PROCESS_SHOW_SECOND_FORM;
            } else if ($submittedLeadId == $this->secondQuoteId) {
                // le deuxieme case! stash details again and show the final confirm form.
                if (!is_array($_SESSION['case'])) {
                    throw new QxException("Missing first case details");
                }
                $_SESSION['case'] += $values['case'];

                return self::STATE_PROCESS_SHOW_CONFIRM_PAGE;
            } else {
                throw new QxException("Unexpected second case ID:" . $submittedLeadId);
            }
        } else {
            // only ever entering one set of details, so just copy them.
            $_SESSION['case'] = $values['case'];
            return self::STATE_PROCESS_SAVED_DETAILS;
        }
    }

    public function submitInstruction(AbstractInstruct $instructor) {
        $first = $this->firstQuoteInstruct;
        if ($this->quoteApiDetails->hasSecondQuote()) {
            $second = $this->secondQuoteInstruct;
        } else {
            $second = null;
        }

        return $instructor->instruct($first, $second);
    }

    public function getCaseDetails($quoteId) {
        if ($quoteId == $this->firstQuoteId) {
            return $this->firstQuoteInstruct;
        } else if ($quoteId == $this->quoteApiDetails->getSecondQuoteId()) {
            return $this->secondQuoteInstruct;
        } else {
            throw new QxException("Bad quote ID requested: $quoteId wanted from {$this->firstQuoteId}");
        }
    }

    public function getSubmittedInstructionDetails() {
        return $_SESSION['case'];
    }

    public function readyForSubmission() {
        $result = $this->firstQuoteInstruct->readyForSubmission();
        if (!empty($this->secondQuoteInstruct)) $result &= $this->secondQuoteInstruct->readyForSubmission();

        return $result;
    }

    public function getSecondQuoteId() {
        return $this->secondQuoteId;
    }

    public function readyForSecondQuote() {
        return $this->firstQuoteInstruct->readyForSubmission();
    }
}

