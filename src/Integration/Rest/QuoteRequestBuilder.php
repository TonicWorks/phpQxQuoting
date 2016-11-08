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

class QuoteRequestBuilder {
    protected $builder;

    public function __construct(QuoteRequestBuilderInterface $builder) {
        $this->builder = $builder;
    }

    /**
     * @param TransferValues|SaleValues|PurchaseValues|RemortgageValues|ContactDetails $node
     * @throws QxException
     * @return array
     */
    public function build($node) {
        if ($node instanceof PurchaseValues) {
            return $this->builder->buildPurchase($node);
        } else if ($node instanceof SaleValues) {
            return $this->builder->buildSale($node);
        } else if ($node instanceof RemortgageValues) {
            return $this->builder->buildRemortgage($node);
        } else if ($node instanceof TransferValues) {
            return $this->builder->buildTransfer($node);
        } else if ($node instanceof CommPurchaseValues) {
            return $this->builder->buildCommPurchase($node);
        } else if ($node instanceof CommSaleValues) {
            return $this->builder->buildCommSale($node);
        } else if ($node instanceof ContactDetails) {
            return $this->builder->buildContact($node);
        } else if ($node instanceof ScotlandPurchaseValues) {
            return $this->builder->buildScotlandPurchase($node);
        } else if ($node instanceof ScotlandSaleValues) {
            return $this->builder->buildScotlandSale($node);
        } else {
            throw new QxException("Can't visit " . get_class($node));
        }
    }

}