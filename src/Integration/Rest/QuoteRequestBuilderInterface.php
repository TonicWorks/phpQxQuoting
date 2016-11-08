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

interface QuoteRequestBuilderInterface {
    public function buildContact(ContactDetails $contact);
    public function buildPurchase(PurchaseValues $node);
    public function buildSale(SaleValues $node);
    public function buildRemortgage(RemortgageValues $node);
    public function buildTransfer(TransferValues $node);
    public function buildCommPurchase(CommPurchaseValues $node);
    public function buildCommSale(CommSaleValues $node);
    public function buildScotlandPurchase(ScotlandPurchaseValues $node);
    public function buildScotlandSale(ScotlandSaleValues $node);
}