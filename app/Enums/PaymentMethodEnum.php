<?php

namespace App\Enums;

enum PaymentMethodEnum : string
{
    case Bank_Transfer = 'bank_transfer';
    case By_Cheque = 'by_cheque';
    case Cash = 'cash';
    case Credit_Card = 'credit_card';
    case Debit_Card = 'debit_card';
    case Demand_Draft = 'demand_draft';

    public function getLabel(): string
    {
        return match ($this) {
            self::Bank_Transfer => __('Bank Transfer'),
            self::By_Cheque => __('By Cheque'),
            self::Cash => __('Cash'),
            self::Credit_Card => __('Credit Card'),
            self::Debit_Card => __('Debit Card'),
            self::Demand_Draft => __('Demand Draft'),

        };
    }

}
