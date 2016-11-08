<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\Integration\Rest;

use TonicWorks\Quotexpress\QuoteModel\CommPurchaseValues;
use TonicWorks\Quotexpress\QuoteModel\CommSaleValues;
use TonicWorks\Quotexpress\QuoteModel\ContactDetails;
use TonicWorks\Quotexpress\QuoteModel\PurchaseValues;
use TonicWorks\Quotexpress\QuoteModel\RemortgageValues;
use TonicWorks\Quotexpress\QuoteModel\SaleValues;
use TonicWorks\Quotexpress\QuoteModel\TransferValues;
use TonicWorks\Quotexpress\QuoteModel\ScotlandPurchaseValues;
use TonicWorks\Quotexpress\QuoteModel\ScotlandSaleValues;
use TonicWorks\Quotexpress\Integration\QuotexpressConstants;

class QuotexpressQuoteRequestBuilder implements QuoteRequestBuilderInterface {

    public function buildContact(ContactDetails $contactDetails) {
        $result = array(
            'contacts' => array(
                array(
                    'contact' => array(
                        'title'          => $contactDetails->getTitleType(),
                        'forename'       => $contactDetails->getForename(),
                        'surname'        => $contactDetails->getSurname(),
                        'emailAddress'   => $contactDetails->getEmailAddress(),
                        'homeTelno'      => $contactDetails->getHomeTelNo(),
                        'marketingOptIn' => $contactDetails->getMarketingOptIn(),
                    )
                )
            )
        );

        if ($contactDetails->getVerifiedEmailAddress()) $result['contacts'][0]['contact']['verifiedEmailAddress'] = $contactDetails->getVerifiedEmailAddress();
        if ($contactDetails->getVerifiedTelNo()) $result['contacts'][0]['contact']['verifiedTelNo'] = $contactDetails->getVerifiedTelNo();
        if ($contactDetails->getPostcode() || $contactDetails->getCity()) {
            $result['contacts'][0]['contact']['address'] = [];
        }
        if ($contactDetails->getPostcode()) $result['contacts'][0]['contact']['address']['postcode'] = $contactDetails->getPostcode();
        if ($contactDetails->getCity()) $result['contacts'][0]['contact']['address']['city'] = $contactDetails->getCity();

        return $result;
    }

    public function buildPurchase(PurchaseValues $node) {
        $result = array(
            'conveyancingValues' => array(
                'propertyPrice'   => $node->getPropertyPrice(),
                'tenureTypeId'    => $node->getTenureTypeId(),
                'mortgageTypeId'  => $node->getMortgageTypeId(),
                'involvedParties' => $node->getNoOfBuyers(),
            )
        );

        if ($node->getFeeScaleId()) {
            $scale = $node->getFeeScaleId();
            if (isset($scale['feeScaleId'])) {
                $result['feeScaleIds'] = array($node->getFeeScaleId());
            } else {
                $result['feeScaleIds'] = $node->getFeeScaleId();
            }
        } else {
            $result['workTypeId'] = QuotexpressConstants::WORK_TYPE_PURCHASE;
            $companyIds = $node->getCompanyIds();
            if (!empty($companyIds)) $result['quoteCompanyIds'] = $companyIds;
        }

        if ($node->getIsRightToBuy()) $result['conveyancingValues']['isRightToBuy'] = true;
        if ($node->getIsBuyToLet()) $result['conveyancingValues']['isBuyToLet'] = true;
        if ($node->getIsNewbuild()) $result['conveyancingValues']['isNewbuild'] = true;
        if ($node->getIsSharedOwnership()) $result['conveyancingValues']['isSharedOwnership'] = true;
        if ($node->getIsUnregistered()) $result['conveyancingValues']['isUnregistered'] = true;
        if ($node->getIsFlat()) $result['conveyancingValues']['isFlat'] = true;
        if ($node->getIsAuction()) $result['conveyancingValues']['isAuction'] = true;
        if ($node->getIsHelpToLoan()) $result['conveyancingValues']['isHelpToLoan'] = true;
        if ($node->getIsHelpToMortgage()) $result['conveyancingValues']['isHelpToMortgage'] = true;
        if ($node->getIsHelpToIsa()) $result['conveyancingValues']['isHelpToIsa'] = true;
        if ($node->getIsNewBuyScheme()) $result['conveyancingValues']['isNewBuyScheme'] = true;
        if ($node->getIsAgreed()) $result['conveyancingValues']['isAgreed'] = true;

        return $result;
    }

    public function buildSale(SaleValues $node) {
        $result = array(
            'conveyancingValues' => array(
                'propertyPrice'   => $node->getPropertyPrice(),
                'tenureTypeId'    => $node->getTenureTypeId(),
                'mortgageTypeId'  => $node->getMortgageTypeId(),
                'involvedParties' => $node->getNoOfSellers(),
            ),
        );

        if ($node->getFeeScaleId()) {
            $scale = $node->getFeeScaleId();
            if (isset($scale['feeScaleId'])) {
                $result['feeScaleIds'] = array($node->getFeeScaleId());
            } else {
                $result['feeScaleIds'] = $node->getFeeScaleId();
            }
        } else {
            $result['workTypeId'] = QuotexpressConstants::WORK_TYPE_SALE;
            $companyIds = $node->getCompanyIds();
            if (!empty($companyIds)) $result['quoteCompanyIds'] = $companyIds;
        }


        if ($node->getIsSharedOwnership()) $result['conveyancingValues']['isSharedOwnership'] = true;
        if ($node->getIsUnregistered()) $result['conveyancingValues']['isUnregistered'] = true;
        if ($node->getIsFlat()) $result['conveyancingValues']['isFlat'] = true;
        if ($node->getIsHelpToLoan()) $result['conveyancingValues']['isHelpToLoan'] = true;
        if ($node->getIsHelpToMortgage()) $result['conveyancingValues']['isHelpToMortgage'] = true;
        if ($node->getIsNewBuyScheme()) $result['conveyancingValues']['isNewBuyScheme'] = true;
        if ($node->getIsAgreed()) $result['conveyancingValues']['isAgreed'] = true;

        return $result;
    }

    public function buildRemortgage(RemortgageValues $node) {
        $result = array(
            'conveyancingValues' => array(
                'propertyPrice'   => $node->getAmountBorrowed(),
                'tenureTypeId'    => $node->getTenureTypeId(),
                'involvedParties' => $node->getNoOfOwners(),
            ),
        );

        if ($node->getFeeScaleId()) {
            $scale = $node->getFeeScaleId();
            if (isset($scale['feeScaleId'])) {
                $result['feeScaleIds'] = array($node->getFeeScaleId());
            } else {
                $result['feeScaleIds'] = $node->getFeeScaleId();
            }
        } else {
            $result['workTypeId'] = QuotexpressConstants::WORK_TYPE_REMORTGAGE;
            $companyIds = $node->getCompanyIds();
            if (!empty($companyIds)) $result['quoteCompanyIds'] = $companyIds;
        }

        if ($node->getIsBuyToLet()) $result['conveyancingValues']['isBuyToLet'] = true;

        return $result;
    }

    public function buildTransfer(TransferValues $node) {
        $result = array(
            'conveyancingValues' => array(
                'propertyPrice'              => $node->getTransferPrice(),
                'tenureTypeId'               => $node->getTenureTypeId(),
                'involvedParties'            => $node->getNoOfPeople(),
                'transferMoneyExchanged'     => $node->getMoneyChangingHands(),
                'transferMortgageValue'      => $node->getMortgageValue(),
                'transferPercentTransferred' => $node->getPercentage(),
            ),
        );

        if ($node->getFeeScaleId()) {
            $scale = $node->getFeeScaleId();
            if (isset($scale['feeScaleId'])) {
                $result['feeScaleIds'] = array($node->getFeeScaleId());
            } else {
                $result['feeScaleIds'] = $node->getFeeScaleId();
            }
        } else {
            $result['workTypeId'] = QuotexpressConstants::WORK_TYPE_TRANSFER;
            $companyIds = $node->getCompanyIds();
            if (!empty($companyIds)) $result['quoteCompanyIds'] = $companyIds;
        }


        if ($node->getIsBuyToLet()) $result['conveyancingValues']['isBuyToLet'] = true;

        return $result;
    }

    public function buildCommPurchase(CommPurchaseValues $node) {
        $result = array(
            'conveyancingValues' => array(
                'propertyPrice'   => $node->getPropertyPrice(),
                'tenureTypeId'    => $node->getTenureTypeId(),
                'involvedParties' => $node->getNoOfBuyers(),
                'mortgageTypeId'  => ($node->getIsMortgaged() ? QuoteDetails::MORTGAGE_TYPE_REGULAR : 0)
            )
        );

        if ($node->getFeeScaleId()) {
            $scale = $node->getFeeScaleId();
            if (isset($scale['feeScaleId'])) {
                $result['feeScaleIds'] = array($node->getFeeScaleId());
            } else {
                $result['feeScaleIds'] = $node->getFeeScaleId();
            }
        } else {
            $result['workTypeId'] = QuotexpressConstants::WORK_TYPE_COMM_PURCHASE;
            $companyIds = $node->getCompanyIds();
            if (!empty($companyIds)) $result['quoteCompanyIds'] = $companyIds;
        }

        return $result;
    }

    public function buildCommSale(CommSaleValues $node) {
        $result = array(
            'conveyancingValues' => array(
                'propertyPrice'   => $node->getPropertyPrice(),
                'tenureTypeId'    => $node->getTenureTypeId(),
                'involvedParties' => $node->getNoOfSellers(),
                'mortgageTypeId'  => ($node->getIsMortgaged() ? QuoteDetails::MORTGAGE_TYPE_REGULAR : 0)
            )
        );

        if ($node->getFeeScaleId()) {
            $scale = $node->getFeeScaleId();
            if (isset($scale['feeScaleId'])) {
                $result['feeScaleIds'] = array($node->getFeeScaleId());
            } else {
                $result['feeScaleIds'] = $node->getFeeScaleId();
            }
        } else {
            $result['workTypeId'] = QuotexpressConstants::WORK_TYPE_COMM_SALE;
            $companyIds = $node->getCompanyIds();
            if (!empty($companyIds)) $result['quoteCompanyIds'] = $companyIds;
        }

        return $result;
    }


    public function buildScotlandPurchase(ScotlandPurchaseValues $node) {
        $result = array(
            'conveyancingValues' => array(
                'propertyPrice'   => $node->getPropertyPrice(),
                'mortgageTypeId'  => $node->getMortgageTypeId(),
                'involvedParties' => $node->getNoOfBuyers(),
            )
        );

        if ($node->getFeeScaleId()) {
            $scale = $node->getFeeScaleId();
            if (isset($scale['feeScaleId'])) {
                $result['feeScaleIds'] = array($node->getFeeScaleId());
            } else {
                $result['feeScaleIds'] = $node->getFeeScaleId();
            }
        } else {
            $result['workTypeId'] = QuotexpressConstants::WORK_TYPE_SCOTLAND_PURCHASE;
            $companyIds = $node->getCompanyIds();
            if (!empty($companyIds)) $result['quoteCompanyIds'] = $companyIds;
        }

        if ($node->getIsBuyToLet()) $result['conveyancingValues']['isBuyToLet'] = true;
        if ($node->getIsNewbuild()) $result['conveyancingValues']['isNewbuild'] = true;
        if ($node->getIsUnregistered()) $result['conveyancingValues']['isUnregistered'] = true;
        if ($node->getIsHelpToMortgage()) $result['conveyancingValues']['isHelpToMortgage'] = true;
        if ($node->getIsHelpToIsa()) $result['conveyancingValues']['isHelpToIsa'] = true;

        return $result;
    }

    public function buildScotlandSale(ScotlandSaleValues $node) {
        $result = array(
            'conveyancingValues' => array(
                'propertyPrice'   => $node->getPropertyPrice(),
                'mortgageTypeId'  => $node->getMortgageTypeId(),
                'involvedParties' => $node->getNoOfSellers(),
            ),
        );

        if ($node->getFeeScaleId()) {
            $scale = $node->getFeeScaleId();
            if (isset($scale['feeScaleId'])) {
                $result['feeScaleIds'] = array($node->getFeeScaleId());
            } else {
                $result['feeScaleIds'] = $node->getFeeScaleId();
            }
        } else {
            $result['workTypeId'] = QuotexpressConstants::WORK_TYPE_SCOTLAND_SALE;
            $companyIds = $node->getCompanyIds();
            if (!empty($companyIds)) $result['quoteCompanyIds'] = $companyIds;
        }

        if ($node->getIsHelpToMortgage()) $result['conveyancingValues']['isHelpToMortgage'] = true;

        return $result;
    }

}
 