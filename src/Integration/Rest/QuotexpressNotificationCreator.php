<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\Integration\Rest;

use TonicWorks\Quotexpress\Configuration\QxConfigInterface;

class QuotexpressNotificationCreator {
    /** @var QxConfigInterface */
    private $config;

    public function __construct(QxConfigInterface $config) {
        $this->config = $config;
    }

    public function sendAutomaticQuoteEmail($quoteHash, $to, $templateId) {
        $connection = $this->config->getQxConnection();
        $parameters = array(
            'emailNotificationTemplateId' => $templateId,
            'emailTo' => $to
        );
        return $connection->submitPost("api/1/quotes/{$quoteHash}/notifications.json", $parameters);
    }
}