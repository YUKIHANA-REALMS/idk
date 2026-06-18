<?php

namespace App\Core\Enum;

enum ProductPriceUnitEnum: string
{
    case DAYS = 'days';
    case HOURS = 'hours';
    case MINUTES = 'minutes';

    public static function getChoices(): array
    {
        return [
            'indium.crud.product.days' => self::DAYS,
            'indium.crud.product.hours' => self::HOURS,
            'indium.crud.product.minutes' => self::MINUTES,
        ];
    }
}
