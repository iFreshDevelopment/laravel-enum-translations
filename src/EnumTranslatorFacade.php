<?php

namespace IFresh\EnumTranslations;

use Illuminate\Support\Facades\Facade;

class EnumTranslatorFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'enum-translator';
    }
}
