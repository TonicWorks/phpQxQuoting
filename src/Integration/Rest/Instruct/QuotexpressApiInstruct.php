<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\Integration\Rest\Instruct;

use TonicWorks\Quotexpress\Configuration\QxConfigInterface;
use TonicWorks\Quotexpress\Integration\QuotexpressConstants;

class QuotexpressApiInstruct extends AbstractInstruct {
    /** @var QxConfigInterface */
    private $qxConfig;

    protected $updateByUserId;
    protected $hash;
    protected $jobIds;
    protected $jobHashes;

    /**
     * QuotexpressApiInstruct constructor.
     *
     * @param QxConfigInterface $qxConfig
     */
    public function __construct(QxConfigInterface $qxConfig) {
        $this->qxConfig = $qxConfig;
    }

    public function instruct(QuoteInstructDetails $firstQuote, QuoteInstructDetails $secondQuote = null) {
        $request = $firstQuote->buildQuotexpressRequest();
        $request['instructQuoteEntryIds'] = array($firstQuote->getQuoteId());
        if (!empty($secondQuote)) {
            $secondRequest = $secondQuote->buildQuotexpressRequest();
            $request[$secondQuote->getQuoteId()] = $secondRequest[$secondQuote->getQuoteId()];
            $request['instructQuoteEntryIds'][] = $secondQuote->getQuoteId();
        }

        $request['instructQuoteEntryIds'] = join(",", $request['instructQuoteEntryIds']);

        $success = $this->doInstruction($request, $firstQuote->getHash());

        return $success ? InstructHandler::STATE_INSTRUCT_SUCCESS : InstructHandler::STATE_INSTRUCT_FAILURE;

    }

    public function doInstruction($request, $hash) {
        $response = $this->submitInstructRequest($request, $hash);
        return $this->parseResponse($response);
    }

    protected function getUrl($hash) {
        return "api/1/quotes/{$hash}/instruct.json";
    }

    protected function submitInstructRequest($request, $hash) {
        return $this->qxConfig->getQxConnection()->submitPut($this->getUrl($hash), $request);
    }

    protected function parseResponse($response) {
        $response = json_decode($response, true);
        $acceptedStatuses = array(QuotexpressConstants::STATUS_INSTRUCTED, QuotexpressConstants::STATUS_PARTIALLY_INSTRUCTED);
        if (!empty($response['status'])
            && !empty($response['status']['jobStatusTypeId'])
            && in_array($response['status']['jobStatusTypeId'], $acceptedStatuses)) {

            $this->jobIds = $response['jobIds'];
            $this->jobHashes = $response['jobHashes'];
            return true;
        } else {
            return false;
        }
    }

    public function getInstructedUrls() {
        $result = array();
        foreach($this->jobIds as $jobId => $reference) {
            $url = $this->qxConfig->getBaseUrl() . "/office/job/view/{$jobId}";
            $result[] = "<a href=\"{$url}\">{$reference}</a>";
        }
        return join(" and " , $result);
    }

    public function getJobHashes() {
        return $this->jobHashes;
    }

    /**
     * @param mixed $updateByUserId
     */
    public function setUpdateByUserId($updateByUserId) {
        $this->updateByUserId = $updateByUserId;
    }
}

 