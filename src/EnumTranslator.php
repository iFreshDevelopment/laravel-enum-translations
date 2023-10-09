<?php

namespace IFresh\EnumTranslations;

use BackedEnum;
use Illuminate\Translation\Translator;
use InvalidArgumentException;

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
    public function translate(string $enum): array
    {
        $this->ensureValidEnum($enum);

        $langPath = sprintf('enums.%s', strtolower(class_basename($enum)));

        $result = [];

        foreach($enum::cases() as $case) {
            $languageKey = $langPath.'.'.$case->value;
            $hasTranslation = $this->translator->has($languageKey);

            if(! $hasTranslation) {
                $value = $languageKey;
            } else {
                $value = $this->translator->get($languageKey);
            }

            $result[$case->value] = $value;
        };

        return $result;
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
}
