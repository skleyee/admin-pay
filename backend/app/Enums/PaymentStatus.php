<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Created = 'created';
    case Paid = 'paid';

    public static function getValues(): array
    {
        return [
            self::Created->value,
            self::Paid->value,
        ];
    }

}
