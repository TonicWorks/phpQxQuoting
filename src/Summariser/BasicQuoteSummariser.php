<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\Summariser;

use TonicWorks\Quotexpress\Util\Util;
use TonicWorks\Quotexpress\Integration\QuotexpressConstants;

class BasicQuoteSummariser implements QuoteSummariserInterface {
    const NAME = 'basicQuote';

    /** @inheritdoc */
    public function getName() {
        return self::NAME;
    }

    protected $quote;

    /** @inheritdoc */
    public function summariseQuote($raw, $unwrapQuote) {
        if ($unwrapQuote) {
            $this->quote = $raw['quote'];
        } else {
            $this->quote = $raw;
        }

        $vars = array();

        $firstLeadVars = $this->getFirstLeadSummary();

        if (!$this->isCombinedQuote()) {
            $firstLeadVars[$this->getFirstLeadCaseTypeFlag()] = true;
            $firstLeadVars['quoteSearchPackRelevant']         = $this->isSearchPackRelevant();
            $firstLeadVars['hasRelatedQuote']                 = false;

            ksort($firstLeadVars);

            $vars['quoteSummary'] = $firstLeadVars;
            $vars['quoteDetails'] = array($firstLeadVars);
        } else {
            $secondLeadVars = $this->getSecondLeadSummary();

            $summary = $firstLeadVars;
            foreach ($secondLeadVars as $varName => $value) {
                if (is_array($value)) continue;

                if (!empty($summary[$varName])) {
                    $summary[$varName] = Util::formatNum($summary[$varName] + $value);
                } else {
                    $summary[$varName] = $value;
                }
            }

            if ($this->isSalePurchase()) {
                $summary['quoteTypeSalePurchase']   = true;
                $summary['quoteSearchPackRelevant'] = true;
                $summary['quoteCaseTypeName']       = 'Sale and Purchase';
            } else {
                $summary['quoteTypeTransferRemortgage'] = true;
                $summary['quoteSearchPackRelevant']     = false;
                $summary['quoteCaseTypeName']           = 'Transfer and Remortgage';
            }

            $summary['hasRelatedQuote'] = true;

            $vars['quoteSummary'] = $summary;
            // Make sure both quotes can be displayed alone in the
            // quote details block.
            $vars['quoteDetails'] = array($firstLeadVars, $secondLeadVars);
        }

        $this->populateSystemSpecific($vars);
        $this->populateIntroducerDetails($vars);

        return $vars;
    }

    /** @var string[]|float[]|array|array[] */
    protected $cachedDisplayVariables;

    protected function populateIntroducerDetails(array &$vars) {
        // $vars['quoteNegotiatorContactNo'] = FrontendModel::getModuleSetting(PrsIntegrationConstants::MODULE_NAME, PrsIntegrationConstants::SETTING_CONTACT_NUMBER, '01925 357 180');

        $vars['quoteNegotiatorName']  = "Philip Moreton";
        $vars['quoteNegotiatorEmail'] = "pm@prslimited.co.uk";
    }

    protected function getFirstLeadSummary() {
//        $this->leadIp = reset($this->quote['contacts']);
//        $this->leadIp = $this->leadIp['contact'];

        return $this->summariseWork(reset($this->quote['quoteEntries']));
    }

    protected function getSecondLeadSummary() {
        return $this->summariseWork(end($this->quote['quoteEntries']));
    }

    protected function isCombinedQuote() {
        return count($this->quote['quoteEntries']) > 1;
    }

    protected function getFirstLeadCaseTypeFlag() {
        $caseTypeLookup = array(
            QuotexpressConstants::WORK_TYPE_SALE          => 'quoteTypeSale',
            QuotexpressConstants::WORK_TYPE_PURCHASE      => 'quoteTypePurchase',
            QuotexpressConstants::WORK_TYPE_REMORTGAGE    => 'quoteTypeRemortgage',
            QuotexpressConstants::WORK_TYPE_TRANSFER      => 'quoteTypeTransferOfEquity',
            QuotexpressConstants::WORK_TYPE_COMM_PURCHASE => 'quoteTypeCommPurchase',
            QuotexpressConstants::WORK_TYPE_COMM_SALE     => 'quoteTypeCommSale',
        );

        $quoteEntry = reset($this->quote['quoteEntries']);
        $workType   = $quoteEntry['work']['workTypeId'];

        return $caseTypeLookup[$workType];
    }

    protected function isSearchPackRelevant() {
        $quoteEntry = reset($this->quote['quoteEntries']);
        $workType   = $quoteEntry['work']['workTypeId'];

        return $workType == QuotexpressConstants::WORK_TYPE_PURCHASE;
    }

    protected function isSalePurchase() {
        $quoteEntry = reset($this->quote['quoteEntries']);
        $workType   = $quoteEntry['work']['workTypeId'];

        return in_array($workType, array(QuotexpressConstants::WORK_TYPE_PURCHASE, QuotexpressConstants::WORK_TYPE_SALE));
    }

    protected function populateSystemSpecific(&$vars) {
        $quoteEntry = reset($this->quote['quoteEntries']);

        $assignCompany = $quoteEntry['quotingCompany'];

        $vars['quoteSolicitorName'] = $assignCompany['name'];
        //$vars['quoteSolicitorPublicProfile'] = $assignCompany['publicprofile'];
        $vars['quoteSolicitorTowncity'] = @$assignCompany['address']['city'];
        $vars['quoteSolicitorPostcode'] = @$assignCompany['address']['postcode'];
        $vars['quoteSolicitorLogoUrl']  = @$assignCompany['logoUrl'];

        $vars['caseSolicitorName'] = $vars['quoteSolicitorName'];
        //$vars['caseSolicitorPublicProfile'] = $rawDetails->company->publicprofile;
        $vars['caseSolicitorTowncity']  = @$assignCompany['address']['city'];
        $vars['caseSolicitorPostcode']  = @$assignCompany['address']['postcode'];
        $vars['caseSolicitorLogoUrl']   = @$assignCompany['logoUrl'];
        $vars['caseSolicitorContactNo'] = @$assignCompany['contactNumber'];
    }


    protected function summariseWork($quoteEntry) {
        $vars = array(
            'quoteSnapshotLegalExVat'        => 0,
            'quoteTotalLegalFeesEx'          => 0,
            'quoteOnlyLegalExVat'            => 0,

            'quoteAdditionalCosts'           => array(),
            'quoteDisbursements'             => array(),
            'quoteServiceFees'               => array(),

            'noOfPeople'                     => $quoteEntry['work']['conveyancingValues']['involvedParties'],
            'propertyPrice'                  => $quoteEntry['work']['conveyancingValues']['propertyPrice'],

            'quoteCaseTypeName'              => $quoteEntry['work']['workType']['name'],
            'quoteCaseTypeCssClass'          => str_replace(' ', '', strtolower($quoteEntry['work']['workType']['name'])),
            'quoteCaseTypeVerb'              => $this->getCaseTypeVerb($quoteEntry['work']['workTypeId']),

            'quoteSnapshotDisbursementOther' => 0,
            'quoteTotalVat'                  => 0,

            'quotePartPaymentAmountExVat'    => 0,
            'quotePartPaymentAmountIncVat'   => 0,
        );

        $otherDisbursements = 0;
        $totalDisbursement  = 0;
        $totalService       = 0;
        $vat                = 0;

        foreach ($quoteEntry['fees'] as $fee) {
            if (empty($fee['commission'])) $fee['commission'] = 0;

            switch ($fee['feeCategoryId']) {
            case QuotexpressConstants::FEE_CATEGORY_LEGAL_FEES_ID:
                $vars['quoteSnapshotLegalExVat'] += $fee['value'] + $fee['commission'];
                $vars['quoteTotalLegalFeesEx'] += $fee['value'] + $fee['commission'];
                $vars['quoteOnlyLegalExVat'] += $fee['value'] + $fee['commission'];
                break;
            case QuotexpressConstants::FEE_CATEGORY_ADDITIONAL_COSTS_ID:
                // The snapshot shows the total fees and then has
                // discount values separately.
                if ($fee['value'] > 0) {
                    $vars['quoteSnapshotLegalExVat'] += $fee['value'] + $fee['commission'];
                } else {
                    $vars['hasDiscountFee']   = true;
                    $vars['discountFeeName']  = $fee['name'];
                    $vars['discountFeeExVat'] = Util::formatNum($fee['value'] + $fee['commission']);
                }
                $vars['quoteTotalLegalFeesEx'] += $fee['value'] + $fee['commission'];
                $vars['quoteAdditionalCosts'][] = array(
                    'name'   => $fee['name'],
                    'amount' => Util::formatNum($fee['value']),
                );
                break;
            case QuotexpressConstants::FEE_CATEGORY_DISBURSEMENTS_ID:
                $vars['quoteDisbursements'][] = array(
                    'name'   => $fee['name'],
                    'amount' => Util::formatNum($fee['value']),
                );

                $totalDisbursement += $fee['value'];
                break;
            case QuotexpressConstants::FEE_CATEGORY_SERVICE_FEES_ID:
                $vars['quoteServiceFees'][] = array(
                    'name'   => $fee['name'],
                    'amount' => Util::formatNum($fee['value']),
                );
                $totalService += $fee['value'];
                break;
            default:
                throw new \Exception("Can't handle this category of fee");
            }

            if ($fee['commission'] > 0) {
                $vars['quotePartPaymentAmountExVat'] += $fee['commission'];
                $vars['quotePartPaymentAmountIncVat'] += $fee['commission'] + $fee['commissionTax'];
            }

            switch ($fee['name']) {
            case 'Stamp Duty':
                $vars['quoteSnapshotDisbursementStampDuty'] = Util::formatNum($fee['total']);
                break;
            case 'Land Registry Fee':
                $vars['quoteSnapshotDisbursementLandReg'] = Util::formatNum($fee['total']);
                break;
            case 'Search Pack':
                $vars['quoteSnapshotDisbursementSearchPack'] = Util::formatNum($fee['total']);
                break;
            default:
                if ($fee['feeCategoryId'] == QuotexpressConstants::FEE_CATEGORY_DISBURSEMENTS_ID) {
                    $otherDisbursements += $fee['value'];
                }
            }

            if (!empty($fee['tax'])) $vat += $fee['tax'];
        }

        $vars['quotePartPayment'] = false; // ($lead->companyid == self::COMPANY_ID_TLP);


        $vars['quoteOnlyLegalExVat']            = Util::formatNum($vars['quoteOnlyLegalExVat']);
        $vars['quoteSnapshotDisbursementOther'] = Util::formatNum($otherDisbursements);
        $vars['quoteTotalVat']                  = Util::formatNum($vat);
        $vars['quoteSnapshotSubtotal']          = Util::formatNum($totalDisbursement + $vat);
        $vars['quoteAllDisbursementSubtotal']   = Util::formatNum($totalDisbursement);

        $vars['quoteTotalExVat']  = Util::formatNum($vars['quoteTotalLegalFeesEx'] + $totalDisbursement + $totalService);
        $vars['quoteTotalIncVat'] = Util::formatNum($vars['quoteTotalLegalFeesEx'] + $totalDisbursement + $totalService + $vat);

        $vars['quoteTotalServiceFee'] = Util::formatNum($totalService);

        $vars['quoteTotalExcStampDutyIncVat'] = Util::formatNum(
            $vars['quoteSnapshotLegalExVat'] +
            $otherDisbursements +
            @$vars['quoteSnapshotDisbursementLandReg'] +
            @$vars['quoteSnapshotDisbursementSearchPack'] +
            $vat
        );

        $vars['quoteSnapshotLegalExVat'] = Util::formatNum($vars['quoteSnapshotLegalExVat']);

        return $vars;
    }

    protected function getCaseTypeVerb($caseTypeId) {
        $values = array(
            QuotexpressConstants::WORK_TYPE_SALE       => 'selling',
            QuotexpressConstants::WORK_TYPE_PURCHASE   => 'purchasing',
            QuotexpressConstants::WORK_TYPE_REMORTGAGE => 'remortgaging',
        );

        if (isset($values[$caseTypeId])) {
            return $values[$caseTypeId];
        } else {
            return "conveyancing";
        }
    }
}
 