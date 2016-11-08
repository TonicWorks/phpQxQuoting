<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\Integration\Rest;

use TonicWorks\Quotexpress\Configuration\QxConfigInterface;

class QuotexpressQuoteRetrieve {
    /** @var QxConfigInterface */
    private $qxConfig;

    /** @var string[]|float[]|array[] */
    protected $quote;
    protected $cachedDisplayVariables = array();
    protected $hash;
    protected $leadIp;

    /**
     * QuotexpressQuoteRetrieve constructor.
     *
     * @param QxConfigInterface $qxConfig
     */
    public function __construct(QxConfigInterface $qxConfig) {
        $this->qxConfig = $qxConfig;
    }

    public function retrieveQuote($hash, $extended) {
        $this->hash = $hash;
        $this->retrieveFromApi($this->getJobUrl($hash, $extended));
    }

    public function addCachedSummary($summaryName, $variables) {
        $this->cachedDisplayVariables[$summaryName] = $variables;
    }

    public function getRawDetails() {
        return $this->quote;
    }

    /**
     * @param null $name
     * @return array|object
     */
    public function getVariables($name = null) {
        if (empty($name)) {
            return $this->cachedDisplayVariables;
        } else {
            return $this->cachedDisplayVariables[$name];
        }
    }

    protected function retrieveFromApi($url) {
        $http = $this->qxConfig->getQxConnection();
        $raw = $http->submitGet($url);
        $this->quote = json_decode($raw, true);
    }

    protected function getJobUrl($hash, $extended) {
        if ($extended) $result = $result = 'api/1/quotes/' . $hash . '/extended.json';
        else $result = 'api/1/quotes/' . $hash . '.json';
        return $result;
    }

}
 