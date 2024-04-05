<?php

namespace IFresh\EnumTranslations;

use BackedEnum;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array translate(string $enum)
 * @method static string translateValue(string $enum, BackedEnum $value)
 */
class EnumTranslatorFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'enum-translator';
    }
}
