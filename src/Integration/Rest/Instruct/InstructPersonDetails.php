<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\Integration\Rest\Instruct;

class InstructPersonDetails {
    /** @var InstructAddressDetails */
    protected $address;

    protected $titleTypeId;
    protected $forename;
    protected $surname;
    protected $contactNo;
    protected $emailAddress;

    public function __construct() {
        $this->address = new InstructAddressDetails();
    }

    /**
     * @param mixed $titleTypeId
     */
    public function setTitleTypeId($titleTypeId) {
        $this->titleTypeId = $titleTypeId;
    }

    /**
     * @return mixed
     */
    public function getForename() {
        return $this->forename;
    }

    /**
     * @param mixed $forename
     */
    public function setForename($forename) {
        $this->forename = $forename;
    }

    /**
     * @return mixed
     */
    public function getSurname() {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname) {
        $this->surname = $surname;
    }

    /**
     * @return mixed
     */
    public function getContactNo() {
        return $this->contactNo;
    }

    /**
     * @param mixed $contactNo
     */
    public function setContactNo($contactNo) {
        $this->contactNo = $contactNo;
    }

    /**
     * @return mixed
     */
    public function getEmailAddress() {
        return $this->emailAddress;
    }

    /**
     * @param mixed $emailAddress
     */
    public function setEmailAddress($emailAddress) {
        $this->emailAddress = $emailAddress;
    }

    /**
     * @return mixed
     */
    public function getTitleTypeId() {
        return $this->titleTypeId;
    }

    /**
     * @return \InstructAddressDetails
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * @param \InstructAddressDetails $address
     */
    public function setAddress($address) {
        $this->address = $address;
    }

 }

