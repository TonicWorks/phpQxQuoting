<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress;

use TonicWorks\Quotexpress\Configuration\QxConfigInterface;
use TonicWorks\Quotexpress\Integration\Rest\QuoteCache;
use TonicWorks\Quotexpress\Integration\Rest\QuotexpressNotificationCreator;
use TonicWorks\Quotexpress\Integration\Rest\QuotexpressQuoteCreator;
use TonicWorks\Quotexpress\QuoteModel\QuoteDetails;
use TonicWorks\Quotexpress\Summariser\BasicQuoteSummariser;
use TonicWorks\Quotexpress\Summariser\DiscountFeesSummariser;
use TonicWorks\Quotexpress\Summariser\InstructQuoteSummariser;

class Example {
    /** @var QxConfigInterface */
    private $config;

    /**
     * Example constructor.
     */
    public function __construct(QxConfigInterface $config) {
        $this->config = $config;
    }

    public function createQuote() {
        $input = new QuoteDetails();
        $input->setCampaignId($this->config->getCampaignId());

        $input->getContactDetails()
            ->setTitleType('Mr')
            ->setForename('Forename')
            ->setSurname('Surname')
            ->setHomeTelNo('0123457891')
            ->setEmailAddress('client@example.com')
        ;
        $input->addTransferValues()
            ->setTenureTypeId(QuoteDetails::TENURE_TYPE_FREEHOLD)
            ->setTransferPrice(120000)
            ->setIsBuyToLet(false)
            ->setMoneyChangingHands(0)
            ->setMortgageValue(100000)
            ->setPercentage(50)
        ;

        $creator = new QuotexpressQuoteCreator($this->config);
        if ($creator->getQuote($input)) {
            return $creator->getQuoteHash();
        } else {
            return null;
        }
    }

    public function sendNotification($quoteHash, $clientEmailAddress, $templateId) {
        $notification = new QuotexpressNotificationCreator($this->config);
        $notification->sendAutomaticQuoteEmail($quoteHash, $clientEmailAddress, $templateId);
    }

    public function retrieveQuote($quoteHash) {
        $retrieve = new QuoteCache($this->config);

        $vars = $retrieve->getQxQuote($quoteHash, QuoteCache::QUOTE_SIMPLE, function() {
            return [
                new BasicQuoteSummariser(), new DiscountFeesSummariser(), new InstructQuoteSummariser()
            ];
        });

        return $vars;
    }

}
