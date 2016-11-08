<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\Exception;

class QxException extends \Exception {
    private $request;

    /**
     * QxException constructor.
     *
     * @param $message
     * @param $request
     */
    public function __construct($message, $request = null) {
        parent::__construct($message);

        $this->request = $request;
    }

    /**
     * @return null
     */
    public function getRequest() {
        return $this->request;
    }

    /**
     * @param null $request
     */
    public function setRequest($request) {
        $this->request = $request;
    }
}
