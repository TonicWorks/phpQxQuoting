<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\Integration\Rest;

use TonicWorks\Quotexpress\Summariser\QuoteSummariserInterface;
use TonicWorks\Quotexpress\Configuration\QxConfigInterface;

/**
 * Caches the results of an API query to QX
 *
 * We cache the result because multiple content blocks that the module offers
 * need access to the details from the API.
 *
 */
class QuoteCache {
    const QUOTE_SIMPLE   = false;
    const QUOTE_EXTENDED = true;

    /** @var QxConfigInterface */
    private $config;

    /** @var QuotexpressQuoteRetrieve[] */
    private $qxQuoteCache;

    /**
     * QuoteCache constructor.
     *
     * @param QxConfigInterface $config
     */
    public function __construct(QxConfigInterface $config) {
        $this->config = $config;
    }

    /**
     * @param $hash
     * @param $extended
     * @param callable $summarisers That returns an array of summarisers.
     * @return QuotexpressQuoteRetrieve
     */
    public function getQxQuote($hash, $extended, $summarisers) {
        if (empty($this->qxQuoteCache[$hash])) {
            $quote = new QuotexpressQuoteRetrieve($this->config);
            $quote->retrieveQuote($hash, $extended);
            $this->qxQuoteCache[$hash] = $quote;

            $raw = $quote->getRawDetails();
            $summarisers = $summarisers();

            /** @var $summarisers QuoteSummariserInterface[] */
            foreach($summarisers as $summariser) {
                $quote->addCachedSummary($summariser->getName(), $summariser->summariseQuote($raw, $extended));
            }
        }

        return $this->qxQuoteCache[$hash];
    }

}
