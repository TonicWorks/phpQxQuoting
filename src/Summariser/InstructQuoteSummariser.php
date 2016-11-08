<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\Summariser;
 
use TonicWorks\Quotexpress\Integration\QuotexpressConstants;
use TonicWorks\Quotexpress\Summariser\Summary\QuoteInstructInputs;
use TonicWorks\Quotexpress\Summariser\Summary\QuoteInstructLeadContact;

class InstructQuoteSummariser implements QuoteSummariserInterface {
    /** @inheritdoc */
    public function getName() {
        return 'instruct';
    }

    /** @inheritdoc */
    public function summariseQuote($raw, $unwrapQuote) {
        if ($unwrapQuote) {
            $quote = $raw['quote'];
        } else {
            $quote = $raw;
        }

        $first = reset($quote['quoteEntries']);
        $firstPeople = $first['work']['conveyancingValues']['involvedParties'];
        if (count($quote['quoteEntries']) > 1) {
            $work = end($quote['quoteEntries']);
            $secondEntryId = $work['quoteEntryId'];
            $secondPeople = $work['work']['conveyancingValues']['involvedParties'];
        } else {
            $secondEntryId = null;
            $secondPeople = null;
        }

        $leadIp = reset($quote['contacts']);

        $leadIp = new QuoteInstructLeadContact(
            $leadIp['title'],
            $leadIp['forename'],
            $leadIp['surname'],
            $leadIp['homeTelno'],
            $leadIp['emailAddress']
        );

        $hasServiceFee = false;
        foreach($quote['quoteEntries'] as $quoteEntry) {
            foreach($quoteEntry['fees'] as $fee) {
                $hasServiceFee |= ($fee['feeCategoryId'] == QuotexpressConstants::FEE_CATEGORY_SERVICE_FEES_ID);
            }
        }

        $baseInstructUrl = '/instruct';
        $quoteInstructLink = $baseInstructUrl . "?" . http_build_query(array(
            'qxh' => $quote['hash']
        ));

        return new QuoteInstructInputs(
            $first['quoteEntryId'], $secondEntryId,
            $leadIp,
            $quote['hash'],
            $firstPeople, $secondPeople,
            $hasServiceFee,
            $quoteInstructLink
        );
    }

}
