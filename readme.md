# Simple Enum translations for Laravel
a Laravel package that simplifies the translation of enums in your applications, 
making it easy to associate enum values with translated labels for multiple languages. 
It enhances code readability and maintainability by handling enum translations seamlessly.

This makes it super easy to provide your front-end with a list of enum-keys with
corresponding labels.

## Features
* Automatically load translated labels for your application Enums
* Provide a fallback based on the enum key to easily find missing translations
* Follows the configured locale of your application

## Getting started
1. Use [composer](https://getcomposer.org) to install the package `composer require ifresh/laravel-enum-translations`
2. Publish the configuration files `./artisan vendor:publish --tag=laravel-enum-translations`
3. Modify the `lang/en/enums.php` file OR copy this file to your application's locale folder.

## Example
Given the following enum:
```php
namespace App\Enums;

enum Cards: string
{
    case Hearts = 'hearts';
    case Diamonds = 'diamonds';
    case Clubs = 'clubs';
    case Spades = 'spades';
}
```
You can add translated values by modifying the `lang/en/enums.php` file:
```php
return [
    'cards' => [
        'hearts' => 'Hearts ❤️',
        'diamonds' => 'Diamonds 💎',
        'clubs' => 'Clubs ♣️',
        'spades' => 'Spades ♠️',
    ],
];
```

Now to use these translations in your application by using the `EnumTranslatorFacade`:

If you simply want to get the list of all the translations for a single Enum (for instance when filling a dropdown) you
can use the `translate` method available on the Facade:
```php
use App\Enums\Cards;
use IFresh\EnumTranslations\EnumTranslatorFacade as EnumTranslator;

$translations = EnumTranslator::translate(Cards::class);
/*
 * [
 *   'hearts' => 'Hearts ❤️',
 *   'diamonds' => 'Diamonds 💎',
 *   'clubs' => 'Clubs ♣️',
 *   'spades' => 'Spades ♠️',
 * ]
 */
```
It is also possible to get the translated value for a single enum value, to do this you can use the `translateValue` method instead:
```php
EnumTranslator::translateValue(Cards::class, Cards::Hearts); // 'Hearts ❤️'
```

When you pass `null` as the selected enum value, an empty string is returned:
```php
EnumTranslator::translateValue(Cards::class, null); // '' 
```

## Contributing
All contributions are welcome! Please open a GitHub Issue or create a Pull-request

## License
The Laravel enum translations package is free software released under the MIT License. See [LICENSE.txt](LICENSE.txt) for details.
