<?php

namespace App\Core\Enum;

enum VoucherTypeEnum: string
{
    case BALANCE_TOPUP = 'balance_topup';
    case PAYMENT_DISCOUNT = 'payment_discount';
    case SERVER_DISCOUNT = 'server_discount';

    public static function getChoices(): array
    {
        return [
            'indium.crud.voucher.balance_topup' => self::BALANCE_TOPUP,
            'indium.crud.voucher.payment_discount' => self::PAYMENT_DISCOUNT,
            'indium.crud.voucher.server_discount' => self::SERVER_DISCOUNT,
        ];
    }
}
