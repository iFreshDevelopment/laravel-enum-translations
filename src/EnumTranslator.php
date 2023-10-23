<?php

namespace IFresh\EnumTranslations;

use BackedEnum;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Translation\Translator;
use InvalidArgumentException;
use StringBackedEnum;

class EnumTranslator
{
    public function __construct(
        protected Translator $translator
    ) {
    }

    /**
     * Get a list of all the available keys in the given enum with their translated values loaded from the application
     * translation
     * @param  class-string<BackedEnum>  $enum
     */
    public function translate(string $enum, $value = null): array|string
    {
        $this->ensureValidEnum($enum);

        $className = class_basename($enum);
        $langPath = sprintf('enums.%s', Str::kebab($className));

        if ($value) {
            $this->ensureValidEnumValue($enum, $value);

            $languageKey = "{$langPath}.{$value->value}";

            return $this->translator->get($languageKey);
        }

        return Arr::mapWithKeys(
            array: $enum::cases(),
            callback: function ($case) use ($langPath) {
                return [
                    $case->value => $this->translator->get("{$langPath}.{$case->value}")
                ];
            });
    }

    /**
     * Check if the given class-string refers to a valid backed enum, throw exception otherwise
     *
     * @param  class-string  $enum
     */
    protected function ensureValidEnum(string $enum): void
    {
        if (!enum_exists($enum)) {
            throw new InvalidArgumentException("Passed argument '{$enum}' is not a valid enum.");
        }

        if(!method_exists($enum, 'cases')) {
            throw new InvalidArgumentException('Method `cases` was not found on "'.$enum.'" perhaps not a backed enum.');
        }
    }

    protected function ensureValidEnumValue(string $enum, $value): void
    {
        if (!$value instanceof $enum) {
            throw new InvalidArgumentException("{$value} is not an instance of {$enum}.");
        }
    }
}
