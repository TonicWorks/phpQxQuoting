<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\Integration\Rest\Instruct;

use TonicWorks\Quotexpress\Summariser\Summary\QuoteInstructInputs;

class QuoteInstructDetails {
    /** @var  InstructAddressDetails */
    protected $propertyAddress;
    /** @var  InstructPersonDetails[] */
    protected $people;

    /** @var QuoteInstructInputs */
    protected $quote;
    protected $quoteId;
    protected $hash;
    protected $noPeople;

    public function __construct(QuoteInstructInputs $quote, $quoteId, $hash, $noPeople) {
        $this->quote   = $quote;
        $this->quoteId = $quoteId;
        $this->hash    = $hash;
        $this->noPeople = $noPeople;

        $this->propertyAddress = new InstructAddressDetails();

        $this->populateFromQuote();
    }

    protected function populateFromQuote() {
        if (count($this->people) != $this->noPeople) {
            $this->people = array();
            for ($i = 0; $i < $this->noPeople; $i++) {
                $this->people[] = new InstructPersonDetails();
            }
        }

        if($this->noPeople > 0) {
            /** @var InstructPersonDetails $person */
            $person = reset($this->people);
            $contact = $this->quote->getLeadContact();

            $person->setTitleTypeId($contact->getTitle());
            $person->setForename($contact->getForename());
            $person->setSurname($contact->getSurname());
            $person->setContactNo($contact->getHomeTelno());
            $person->setEmailAddress($contact->getEmailAddress());
        }
    }

    /**
     * @return InstructPersonDetails[]
     */
    public function getPeople() {
        return $this->people;
    }

    public function getPropertyAddress() {
        return $this->propertyAddress;
    }

    public function readyForSubmission() {
        $result =
            $this->propertyAddress->getLine1() != ''
            && $this->propertyAddress->getPostcode() != '';

        $firstPerson = true;
        foreach ($this->people as $person) {
            $addr = $person->getAddress();
            $result &=
                $addr->getLine1() != ''
                && $addr->getPostcode() != ''
                && $person->getSurname() != '';
            if ($firstPerson) {
                $result &=
                    $person->getContactNo() != ''
                    && $person->getEmailAddress() != '';
                $firstPerson = false;
            }
        }

        return $result;
    }

    public function buildQuotexpressRequest() {
        $request = array();

        $request[$this->quoteId] = array(
            'propertyAddress' => array(
                'line1'    => $this->propertyAddress->getLine1(),
                'line2'    => $this->propertyAddress->getLine2(),
                'city'     => $this->propertyAddress->getTowncity(),
                'county'   => $this->propertyAddress->getCountystate(),
                'postcode' => $this->propertyAddress->getPostcode(),
            )
        );

        $request['contacts'] = array();
        //$titles = SpringboardConstants::getTitleTypeIds();

        foreach ($this->people as $person) {
            $addr = $person->getAddress();

            $request['contacts'][] = array(
                'forename' => $person->getForename(),
                'surname' => $person->getSurname(),
                'title' => $person->getTitleTypeId(),
                'homeTelno' => $person->getContactNo(),
                'emailAddress' => $person->getEmailAddress(),
                'address' => array(
                    'line1'    => $addr->getLine1(),
                    'line2'    => $addr->getLine2(),
                    'city'     => $addr->getTowncity(),
                    'county'   => $addr->getCountystate(),
                    'postcode' => $addr->getPostcode(),
                )
            );
        }

        return $request;
    }

    /**
     * @return int
     */
    public function getQuoteId() {
        return $this->quoteId;
    }

    /**
     * @return mixed
     */
    public function getHash() {
        return $this->hash;
    }
}

