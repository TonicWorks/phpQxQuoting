<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\Configuration;

use TonicWorks\Quotexpress\Integration\Rest\HttpRequest;

class QxConfig implements QxConfigInterface {
    /** @var string */
    private $baseUrl;
    /** @var string */
    private $username;
    /** @var string */
    private $password;
    /** @var int */
    private $campaignId;
    /** @var int */
    private $notificationTemplateId;

    /**
     * QxConfig constructor.
     *
     * @param string $baseUrl
     * @param string $username
     * @param string $password
     * @param int $campaignId
     */
    public function __construct($baseUrl, $username, $password, $campaignId) {
        $this->baseUrl    = $baseUrl;
        $this->username   = $username;
        $this->password   = $password;
        $this->campaignId = $campaignId;
    }

    public function getQxConnection() {
        return new HttpRequest($this->baseUrl, $this->username, $this->password);
    }

    /**
     * @return string
     */
    public function getBaseUrl() {
        return $this->baseUrl;
    }

    /** @return int */
    public function getCampaignId() {
        return $this->campaignId;
    }

    /** @return int */
    public function getNotificationTemplateId() {
        return $this->notificationTemplateId;
    }
}
