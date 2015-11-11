<?php

namespace Rebuy\EanIsbn\Tests\Converter;

use Rebuy\EanIsbn\Converter\Isbn10Converter;
use Rebuy\EanIsbn\Identifier\Ean13;
use Rebuy\EanIsbn\Identifier\Ean8;
use Rebuy\EanIsbn\Identifier\Isbn10;

class Isbn10ConverterTest extends AbstractConverterTest
{
    public function setUp()
    {
        $this->converter = new Isbn10Converter($this->getMockChecksumCalculator());
    }

    /**
     * @test
     * @dataProvider \Rebuy\EanIsbn\Tests\Helper\IdentifierProvider::provideValidIsbn10
     * @param string $value
     */
    public function convert_creates_correct_ean13_conversion($value)
    {
        $isbn10toEanPrefix = '978';
        $ean13 = new Ean13($isbn10toEanPrefix . str_replace('-', '', $value));
        $isbn10 = $this->converter->convert($ean13);
        list($isbn10WithoutChecksum, $isbn10Checksum) = str_split($isbn10->getValue(), 9);

        $this->assertInstanceOf(Isbn10::class, $isbn10);
        $valueWithoutChecksum = substr($ean13->getValue(), 0, -1);
        $this->assertEquals($valueWithoutChecksum, $isbn10toEanPrefix . $isbn10WithoutChecksum);

        $this->assertEquals($this->getValidChecksum(), $isbn10Checksum);
    }

    /**
     * @test
     * @dataProvider \Rebuy\EanIsbn\Tests\Helper\IdentifierProvider::provideValidIsbn10
     * @param string $value
     * @expectedException \Rebuy\EanIsbn\Exception\ConversionException
     */
    public function convert_rejects_ean13_without_correct_prefix($value)
    {
        $ean13 = new Ean13('979' . str_replace('-', '', $value));

        $this->converter->convert($ean13);
    }

    /**
     * @test
     * @dataProvider \Rebuy\EanIsbn\Tests\Helper\IdentifierProvider::provideValidEan8
     * @param string $value
     * @expectedException \Rebuy\EanIsbn\Exception\ConversionException
     */
    public function convert_rejects_identifier_without_isbn10_conversion($value)
    {
        $ean8 = new Ean8(str_replace('-', '', $value));

        $this->converter->convert($ean8);
    }
}
