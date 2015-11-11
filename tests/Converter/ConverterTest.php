<?php

namespace Rebuy\EanIsbn\Tests\Converter;

use Rebuy\EanIsbn\Converter\Converter;
use Rebuy\EanIsbn\Converter\ConverterInterface;
use Rebuy\EanIsbn\Exception\ConversionException;
use Rebuy\EanIsbn\Identifier\Ean13;
use Rebuy\EanIsbn\Identifier\Ean8;

class ConverterTest extends AbstractConverterTest
{
    public function setUp()
    {
        $this->converter = new Converter();
    }

    /**
     * @test
     * @expectedException \Rebuy\EanIsbn\Exception\ConversionException
     */
    public function convert_tries_all_specialized_converters_before_throwing()
    {
        $value = 'VALUE';
        $exception = new ConversionException('');

        $specializedConverter1 = $this->getMock(ConverterInterface::class);
        $specializedConverter1
            ->expects($this->once())
            ->method('convert')
            ->with($value)
            ->willThrowException($exception);
        $specializedConverter2 = $this->getMock(ConverterInterface::class);
        $specializedConverter2
            ->expects($this->once())
            ->method('convert')
            ->with($value)
            ->willThrowException($exception);

        $converter = new Converter([Ean13::class => [$specializedConverter1, $specializedConverter2]]);
        $converter->convert(new Ean13($value));
    }

    /**
     * @test
     * @expectedException \Rebuy\EanIsbn\Exception\ConversionException
     */
    public function convert_ignores_specialized_converters_for_wrong_type()
    {
        $value = 'VALUE';

        $specializedConverter = $this->getMock(ConverterInterface::class);
        $specializedConverter->expects($this->never())->method('convert');

        $converter = new Converter([Ean13::class => [$specializedConverter]]);
        $converter->convert(new Ean8($value));
    }

    /**
     * @test
     */
    public function convert_passes_identifier_from_specialized_converter()
    {
        $value = 'VALUE';
        $identifier = new Ean13($value);
        $expectedIdentifier = new Ean8($value);

        $specializedConverter = $this->getMock(ConverterInterface::class);
        $specializedConverter
            ->expects($this->once())
            ->method('convert')
            ->with($identifier)
            ->willReturn($expectedIdentifier);

        $converter = new Converter([Ean13::class => [$specializedConverter]]);
        $convertedIdentifier = $converter->convert($identifier);

        $this->assertEquals($expectedIdentifier, $convertedIdentifier);
    }
}
