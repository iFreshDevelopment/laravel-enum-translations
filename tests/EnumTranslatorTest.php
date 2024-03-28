<?php

use IFresh\EnumTranslations\EnumTranslator;
use Illuminate\Contracts\Translation\Translator;
use Tests\Standin\TestEnum;

beforeEach(function() {
    $this->translatorMock = Mockery::mock(Translator::class);

    $this->enumTranslator = new EnumTranslator($this->translatorMock);
});

it('returns translations for all enum values', function () {
    $this->translatorMock->shouldReceive('get')
        ->with('enums.test-enum.value_1')
        ->andReturn('Value 1');
    $this->translatorMock->shouldReceive('get')
        ->with('enums.test-enum.value_2')
        ->andReturn('Value 2');

    $result = $this->enumTranslator->translate(TestEnum::class);

    expect($result)
        ->toBeArray()
        ->toMatchArray([
            'value_1' => 'Value 1',
            'value_2' => 'Value 2',
        ]);
});

it('returns a translation for a single enum value', function () {
    $this->translatorMock->shouldReceive('get')
        ->with('enums.test-enum.value_1')
        ->andReturn('Value 1');

    $result = $this->enumTranslator->translateValue(TestEnum::class, TestEnum::Value1);

    expect($result)
        ->toBe('Value 1');
});

it('returns an empty string when no backing value is given', function () {
    $result = $this->enumTranslator->translateValue(TestEnum::class, null);

    expect($result)
        ->toBe('');
});

it('`translate` guards against invalid enums', function () {
    $mock = new class {};

    $this->enumTranslator->translate($mock::class);
})->expectException(InvalidArgumentException::class);

it('`translateValue` guards against invalid enums', function () {
    $mock = new class {
        const Value1 = 'value_1';
    };

    $this->enumTranslator->translateValue($mock::class, TestEnum::Value1);
})->expectException(InvalidArgumentException::class);
