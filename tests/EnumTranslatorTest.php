<?php

use IFresh\EnumTranslations\EnumTranslator;
use Illuminate\Contracts\Translation\Translator;
use Tests\Standin\TestEnum;

it('returns translations for all enum values', function () {
    $translator = Mockery::mock(Translator::class);
    $translator->shouldReceive('get')
        ->with('enums.test-enum.value_1')
        ->andReturn('Value 1');
    $translator->shouldReceive('get')
        ->with('enums.test-enum.value_2')
        ->andReturn('Value 2');

    $enumTranslator = new EnumTranslator($translator);

    $result = $enumTranslator->translate(TestEnum::class);

    expect($result)
        ->toBeArray()
        ->toMatchArray([
            'value_1' => 'Value 1',
            'value_2' => 'Value 2',
        ]);
});

it('returns a translation for a single enum value', function () {
    $translator = Mockery::mock(Translator::class);
    $translator->shouldReceive('get')
        ->with('enums.test-enum.value_1')
        ->andReturn('Value 1');

    $enumTranslator = new EnumTranslator($translator);

    $result = $enumTranslator->translateValue(TestEnum::class, TestEnum::Value1);

    expect($result)
        ->toBe('Value 1');
});
