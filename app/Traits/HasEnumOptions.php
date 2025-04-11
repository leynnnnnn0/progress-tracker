<?php

namespace App\Traits;

trait HasEnumOptions
{
    public static function options()
    {
        $data = array_column(self::cases(), 'value');
        return array_combine($data, $data);
    }
}
