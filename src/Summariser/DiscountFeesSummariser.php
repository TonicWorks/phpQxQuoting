<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\Summariser;

use TonicWorks\Quotexpress\Util\Util;
use TonicWorks\Quotexpress\Integration\QuotexpressConstants;

class DiscountFeesSummariser implements QuoteSummariserInterface {
    /** @inheritdoc */
    public function getName() {
        return 'discountFees';
    }

    protected $quote;

    /** @inheritdoc */
    /** @inheritdoc */
    public function summariseQuote($raw, $unwrapQuote) {
        if ($unwrapQuote) {
            $this->quote = $raw['quote'];
        } else {
            $this->quote = $raw;
        }

        $vars = array();

        $firstLeadVars = $this->getFirstLeadSummary();

        $parts = array('preDiscount', 'withDiscount');

        if (!$this->isCombinedQuote()) {
            $firstLeadVars['hasRelatedQuote'] = false;
            ksort($firstLeadVars);
            $vars['quoteSummary'] = $firstLeadVars;
            $vars['quoteDetails'] = array($firstLeadVars);
        } else {
            $secondLeadVars = $this->getSecondLeadSummary();

            $summary = $firstLeadVars;
            foreach($parts as $summaryPart) {
                foreach ($secondLeadVars[$summaryPart] as $varName => $value) {
                    if (is_array($value)) continue;

                    if (!empty($summary[$summaryPart][$varName])) {
                        $summary[$summaryPart][$varName] = Util::formatNum($summary[$summaryPart][$varName] + $value);
                    } else {
                        $summary[$summaryPart][$varName] = $value;
                    }
                }
            }

            $summary['hasRelatedQuote'] = true;

            $vars['quoteSummary'] = $summary;
            // Make sure both quotes can be displayed alone in the
            // quote details block.
            $vars['quoteDetails'] = array($firstLeadVars, $secondLeadVars);
        }

        return $vars;
    }

    protected function getFirstLeadSummary() {
        return $this->summariseWork(reset($this->quote['quoteEntries']));
    }

    protected function getSecondLeadSummary() {
        return $this->summariseWork(end($this->quote['quoteEntries']));
    }

    protected function isCombinedQuote() {
        return count($this->quote['quoteEntries']) > 1;
    }

    protected function summariseWork($quoteEntry) {
        $preDiscount  = array(
            'totalLegalEx'        => 0,
            'totalDisbursementEx' => 0,
            'totalServiceFeeEx'   => 0,
            'legal'               => array(),
            'disbursement'        => array(),

            'totalEx'             => 0,
            'tax'                 => 0,
            'totalInc'            => 0,
        );

        $withDiscount = array(
            'totalDiscountInc' => 0,
            'absDiscountInc'   => 0,
            'totalInc'         => 0,
        );

        foreach ($quoteEntry['fees'] as $fee) {
            if (empty($fee['commission'])) $fee['commission'] = 0;

            switch ($fee['feeCategoryId']) {
            case QuotexpressConstants::FEE_CATEGORY_LEGAL_FEES_ID:
                if ($fee['value'] < 0) {
                    $withDiscount['totalDiscountInc'] += $fee['value'] + $fee['commission'] + $fee['tax'];
                } else {
                    $preDiscount['totalLegalEx'] += $fee['value'] + $fee['commission'];
                    $preDiscount['legal'][] = array(
                        'name'   => $fee['name'],
                        'amount' => Util::formatNum($fee['value']),
                    );
                }
                break;
            case QuotexpressConstants::FEE_CATEGORY_ADDITIONAL_COSTS_ID:
                // The snapshot shows the total fees and then has
                // discount values separately.
                if ($fee['value'] < 0) {
                    $withDiscount['totalDiscountInc'] += $fee['value'] + $fee['commission'] + $fee['tax'];
                } else {
                    $preDiscount['totalLegalEx'] += $fee['value'] + $fee['commission'];
                }
                $preDiscount['legal'][] = array(
                    'name'   => $fee['name'],
                    'amount' => Util::formatNum($fee['value']),
                );
                break;
            case QuotexpressConstants::FEE_CATEGORY_DISBURSEMENTS_ID:
                $preDiscount['totalDisbursementEx'] += $fee['value'] + $fee['commission'];
                $preDiscount['disbursement'][] = array(
                    'name'   => $fee['name'],
                    'amount' => Util::formatNum($fee['value']),
                );
                break;
            case QuotexpressConstants::FEE_CATEGORY_SERVICE_FEES_ID:
                $preDiscount['totalServiceFeeEx'] += $fee['value'];
                break;
            default:
                throw new \Exception("Can't handle this category of fee");
            }

            if ($fee['value'] > 0) {
                $preDiscount['tax'] += $fee['tax'];
            }
        }

        $preDiscount['totalEx'] = $preDiscount['totalLegalEx'] + $preDiscount['totalDisbursementEx'] + $preDiscount['totalServiceFeeEx'];
        $preDiscount['totalInc'] = $preDiscount['totalEx'] + $preDiscount['tax'];

        $withDiscount['totalInc'] = $preDiscount['totalInc'] + $withDiscount['totalDiscountInc'];
        $withDiscount['absDiscountInc'] = abs($withDiscount['totalDiscountInc']);

        foreach($preDiscount as $idx => $val) {
            if (!is_array($val)) {
                $preDiscount[$idx] = Util::formatNum($val);
            }
        }
        foreach($withDiscount as $idx => $val) {
            $withDiscount[$idx] = Util::formatNum($val);
        }

        return array(
            'preDiscount'  => $preDiscount,
            'withDiscount' => $withDiscount,
            'caseTypeName' => $quoteEntry['work']['workType']['name'],
        );
    }
}
 