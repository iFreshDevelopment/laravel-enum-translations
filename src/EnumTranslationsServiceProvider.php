<?php

namespace IFresh\EnumTranslations;

use Illuminate\Support\ServiceProvider;

class EnumTranslationsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->alias(EnumTranslator::class, 'enum-translator');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/enum-translations.php' => config_path('enum-translations.php'),
            __DIR__.'/../lang/en/enums.php' => lang_path('en/enums.php'),
        ], 'laravel-enum-translations');
    }
}
