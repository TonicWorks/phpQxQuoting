<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\Integration\Rest;

use TonicWorks\Quotexpress\Exception\QxException;
use TonicWorks\Quotexpress\Configuration\QxConfigInterface;
use TonicWorks\Quotexpress\QuoteModel\QuoteDetails;

class QuotexpressQuoteCreator implements QuoteInteractionInterface {
    /** @var QxConfigInterface */
    private $qxConfig;

    protected $quoteId;
    protected $quoteHash;

    protected $clientEmail;
    protected $negotiatorUserId;
    protected $workReferences;
    protected $quoteEntryIds;
    protected $companyIds;

    /**
     * QuotexpressQuoteCreator constructor.
     *
     * @param QxConfigInterface $qxConfig
     */
    public function __construct(QxConfigInterface $qxConfig) {
        $this->qxConfig = $qxConfig;
    }

    public function getQuote(QuoteDetails $details) {
        $request = $this->buildRequest($details);
        $response = $this->submitRequest('api/1/quotes.json', $request);
        return $this->parseResponse($response, $request);
    }

    protected function buildRequest(QuoteDetails $details) {
        $builder = new QuoteRequestBuilder(new QuotexpressQuoteRequestBuilder());

        $request = $details->buildRequest();

        $request += $builder->build($details->getContactDetails());

        $jobs = array();
        foreach($details->getExtraDetails() as $node) {
            $jobs[] = $builder->build($node);
        }

        $request['quoteEntries'] = $jobs;

        return $request;
    }

    protected function submitRequest($url, $request) {
        return $this->qxConfig->getQxConnection()->submitPost($url, $request);
    }

    protected function parseResponse($response, $request) {
        if ($response === false) {
            throw new QxException('Failed to build QX job, just false and ' .json_encode($request));
        }

        $result = json_decode($response, true);

        if ($result === null || empty($result['quoteId']) || isset($result['error'])) {
            throw new QxException('Failed to build QX job on ' . $this->qxConfig->getBaseUrl() .
                ", " .  json_encode($response) . ' and ' . json_encode($request)
            );
        }

        $this->quoteId = $result['quoteId'];
        $this->quoteHash = $result['hash'];
        $this->clientEmail = $result['contacts'][0]['emailAddress'];
        $this->workReferences = array();
        $this->quoteEntryIds = array();
        $this->companyIds = array();
        foreach($result['quoteEntries'] as $quoteEntry) {
            $work = $quoteEntry['work'];
            $this->workReferences[$work['reference']] = $work['reference'];
            $this->quoteEntryIds[] = $quoteEntry['quoteEntryId'];
            $this->companyIds[] = $quoteEntry['quotingCompanyId'];
        }
        $this->workReferences = implode(' and ', $this->workReferences);

        return true;
    }

    public function getQuoteHash() {
        return $this->quoteHash;
    }

    public function getLeadId() {
        return $this->quoteId;
    }

    public function getLeadReference() {
        return $this->workReferences;
    }

    public function getQuotedCompanyIds() {
        return $this->companyIds;
    }

    public function getOfficeLink() {
        return $this->qxConfig->getBaseUrl() . 'office/quote/view/' . $this->quoteId;
    }

    public function sendClientNotification() {
        $email = $this->clientEmail;

        if ($this->qxConfig->getNotificationTemplateId() > 0) {
            $notificationSender = QuotexpressNotificationCreator::instance();
            $notificationSender->sendAutomaticQuoteEmail($this->quoteHash, $email, $this->qxConfig->getNotificationTemplateId());
        }
    }

    protected function getFeeUrl($hash, $quoteEntryId) {
        return $this->qxConfig->getBaseUrl() . 'api/1/quotes/' . $hash . '/entries/' . $quoteEntryId . '/fees.json';
    }
}
 