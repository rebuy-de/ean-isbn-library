<?php

namespace Rebuy\EanIsbn\Tests\Converter;

use Rebuy\EanIsbn\Converter\Ean8Converter;
use Rebuy\EanIsbn\Identifier\Ean13;
use Rebuy\EanIsbn\Identifier\Ean8;
use Rebuy\EanIsbn\Identifier\Isbn10;

class Ean8ConverterTest extends AbstractConverterTest
{
    public function setUp() {
        $this->converter = new Ean8Converter();
    }

    /**
     * @test
     * @dataProvider \Rebuy\EanIsbn\Tests\Helper\IdentifierProvider::provideValidEan8
     * @param string $value
     */
    public function convert_creates_correct_ean13_conversion($value)
    {
        $value = str_replace('-', '', $value);
        $ean8ToEan13Prefix = '00000';
        $ean8 = $this->converter->convert(new Ean13($ean8ToEan13Prefix . $value));

        $this->assertInstanceOf(Ean8::class, $ean8);
        $this->assertEquals($value, $ean8->getValue());
    }

    /**
     * @test
     * @dataProvider \Rebuy\EanIsbn\Tests\Helper\IdentifierProvider::provideValidEan8
     * @param string $value
     * @expectedException \Rebuy\EanIsbn\Exception\ConversionException
     */
    public function convert_rejects_ean13_without_correct_prefix($value)
    {
        $ean13 = new Ean13('10000' . $value);

        $this->converter->convert($ean13);
    }

    /**
     * @test
     * @dataProvider \Rebuy\EanIsbn\Tests\Helper\IdentifierProvider::provideValidIsbn10
     * @param string $value
     * @expectedException \Rebuy\EanIsbn\Exception\ConversionException
     */
    public function convert_rejects_identifier_without_ean8_conversion($value)
    {
        $this->converter->convert(new Isbn10(str_replace('-', '', $value)));
    }
}
