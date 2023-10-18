<?php

namespace IFresh\EnumTranslations;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array translate(string $enum)
 */
class EnumTranslatorFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'enum-translator';
    }
}
