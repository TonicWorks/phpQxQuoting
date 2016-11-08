<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\Integration\Rest\Instruct;

class InstructAddressDetails {
    protected $line1;
    protected $line2;
    protected $towncity;
    protected $countystate;
    protected $country;
    protected $postcode;

    /**
     * @param mixed $line1
     */
    public function setLine1($line1) {
        $this->line1 = $line1;
    }

    /**
     * @param mixed $line2
     */
    public function setLine2($line2) {
        $this->line2 = $line2;
    }

    /**
     * @param mixed $towncity
     */
    public function setTowncity($towncity) {
        $this->towncity = $towncity;
    }

    /**
     * @param mixed $countystate
     */
    public function setCountystate($countystate) {
        $this->countystate = $countystate;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country) {
        $this->country = $country;
    }

    /**
     * @param mixed $postcode
     */
    public function setPostcode($postcode) {
        $this->postcode = $postcode;
    }

    /**
     * @return mixed
     */
    public function getLine1() {
        return $this->line1;
    }

    /**
     * @return mixed
     */
    public function getLine2() {
        return $this->line2;
    }

    /**
     * @return mixed
     */
    public function getTowncity() {
        return $this->towncity;
    }

    /**
     * @return mixed
     */
    public function getCountystate() {
        return $this->countystate;
    }

    /**
     * @return mixed
     */
    public function getCountry() {
        return $this->country;
    }

    /**
     * @return mixed
     */
    public function getPostcode() {
        return $this->postcode;
    }
}

