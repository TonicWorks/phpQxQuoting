<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\Configuration;

use TonicWorks\Quotexpress\Integration\Rest\HttpRequest;

interface QxConfigInterface {
    /** @return HttpRequest */
    public function getQxConnection();

    /** @return string */
    public function getBaseUrl();

    /** @return int */
    public function getCampaignId();

    /** @return int */
    public function getNotificationTemplateId();
}
