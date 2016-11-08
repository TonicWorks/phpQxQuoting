<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\QuoteModel;

class ContactDetails {
    // CONTACT DETAILS
    /** @var string */
    protected $titleType;
    /** @var string */
    protected $forename;
    /** @var string */
    protected $surname;
    /** @var string */
    protected $emailAddress;
    /** @var string */
    protected $homeTelNo;
    /** @var boolean */
    protected $marketingOptIn = false;
    /** @var boolean */
    protected $verifiedEmailAddress;
    /** @var boolean */
    protected $verifiedTelNo;

    /** @var string */
    private $city;
    /** @var string */
    private $postcode;

    public function validate() {
        $personalErrors = array();

        if (empty($this->forename)) $personalErrors['forename'] = "Forename is required";
        if (empty($this->surname)) $personalErrors['surname'] = "Surname is required";
        if (empty($this->titleType)) $personalErrors['titleTypeId'] = "Title is required";
        if (empty($this->emailAddress)) $personalErrors['emailAddress'] = "Email address is required";
        if (filter_var($this->emailAddress, FILTER_VALIDATE_EMAIL) === false) $personalErrors['emailAddress'] = "Valid email address is required";
        if (empty($this->homeTelNo)) $personalErrors['homeTelNo'] = "Telephone number is required";

        return $personalErrors;
    }

    /**
     * @param string $titleType
     * @return ContactDetails
     */
    public function setTitleType($titleType) {
        $this->titleType = $titleType;
        return $this;
    }

    /**
     * @param string $forename
     * @return ContactDetails
     */
    public function setForename($forename) {
        $this->forename = $forename;
        return $this;
    }

    /**
     * @param string $surname
     * @return ContactDetails
     */
    public function setSurname($surname) {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @param string $emailAddress
     * @return ContactDetails
     */
    public function setEmailAddress($emailAddress) {
        $this->emailAddress = $emailAddress;
        return $this;
    }

    /**
     * @param string $homeTelNo
     * @return ContactDetails
     */
    public function setHomeTelNo($homeTelNo) {
        $this->homeTelNo = $homeTelNo;
        return $this;
    }

    /**
     * @param boolean $marketingOptIn
     * @return ContactDetails
     */
    public function setMarketingOptIn($marketingOptIn) {
        $this->marketingOptIn = $marketingOptIn;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitleType() {
        return $this->titleType;
    }

    /**
     * @return mixed
     */
    public function getForename() {
        return $this->forename;
    }

    /**
     * @return mixed
     */
    public function getSurname() {
        return $this->surname;
    }

    /**
     * @return mixed
     */
    public function getEmailAddress() {
        return $this->emailAddress;
    }

    /**
     * @return mixed
     */
    public function getHomeTelNo() {
        return $this->homeTelNo;
    }

    /**
     * @return boolean
     */
    public function getMarketingOptIn() {
        return $this->marketingOptIn;
    }

    /**
     * @param boolean $verifiedEmailAddress
     * @return ContactDetails
     */
    public function setVerifiedEmailAddress($verifiedEmailAddress) {
        $this->verifiedEmailAddress = $verifiedEmailAddress;
        return $this;
    }

    /**
     * @param boolean $verifiedTelNo
     * @return ContactDetails
     */
    public function setVerifiedTelNo($verifiedTelNo) {
        $this->verifiedTelNo = $verifiedTelNo;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getVerifiedEmailAddress() {
        return $this->verifiedEmailAddress;
    }

    /**
     * @return boolean
     */
    public function getVerifiedTelNo() {
        return $this->verifiedTelNo;
    }

    /**
     * @return string
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * @param string $city
     * @return ContactDetails
     */
    public function setCity($city) {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostcode() {
        return $this->postcode;
    }

    /**
     * @param string $postcode
     * @return ContactDetails
     */
    public function setPostcode($postcode) {
        $this->postcode = $postcode;
        return $this;
    }
}

