<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\Integration\Rest;

interface QuoteInteractionInterface {
    public function getLeadId();
    public function getOfficeLink();
    public function sendClientNotification();
    public function getLeadReference();
}
 