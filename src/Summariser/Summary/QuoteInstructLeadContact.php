<?php
/**
 * @copyright Totem Media (c) 2012/13/14 
 */

namespace TonicWorks\Quotexpress\Summariser\Summary;
 
class QuoteInstructLeadContact {
    protected $title;
    protected $forename;
    protected $surname;
    protected $homeTelno;
    protected $emailAddress;

    function __construct($title, $forename, $surname, $homeTelno, $emailAddress) {
        $this->title        = $title;
        $this->forename     = $forename;
        $this->surname      = $surname;
        $this->homeTelno    = $homeTelno;
        $this->emailAddress = $emailAddress;
    }

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
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
    public function getHomeTelno() {
        return $this->homeTelno;
    }

    /**
     * @return mixed
     */
    public function getEmailAddress() {
        return $this->emailAddress;
    }

}
 