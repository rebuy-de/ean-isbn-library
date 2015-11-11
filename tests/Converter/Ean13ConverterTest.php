<?php

namespace Rebuy\EanIsbn\Tests\Converter;

use Rebuy\EanIsbn\Converter\Ean13Converter;
use Rebuy\EanIsbn\Identifier\Ean13;
use Rebuy\EanIsbn\Identifier\Ean8;
use Rebuy\EanIsbn\Identifier\IdentifierInterface;
use Rebuy\EanIsbn\Identifier\Isbn10;

class Ean13ConverterTest extends AbstractConverterTest
{
    public function setUp()
    {
        $this->converter = new Ean13Converter($this->getMockChecksumCalculator());
    }

    /**
     * @test
     * @dataProvider \Rebuy\EanIsbn\Tests\Helper\IdentifierProvider::provideValidEan13
     * @param $value
     */
    public function convert_converts_ean8_to_ean13($value)
    {
        $ean13 = $this->converter->convert(new Ean8($value));

        $this->assertInstanceOf(Ean13::class, $ean13);
        $this->assertEquals('00000' . $value, $ean13->getValue());
    }

    /**
     * @test
     * @dataProvider \Rebuy\EanIsbn\Tests\Helper\IdentifierProvider::provideValidIsbn10
     * @param $value
     */
    public function convert_converts_isbn10_to_ean13($value)
    {
        $isbn10 = new Isbn10(str_replace('-', '', $value));
        $valueWithoutChecksum = substr($isbn10->getValue(), 0, -1);

        $ean13 = $this->converter->convert($isbn10);
        $ean13WithoutChecksum = substr($ean13->getValue(), 0, -1);

        $this->assertInstanceOf(Ean13::class, $ean13);
        $this->assertEquals('978' . $valueWithoutChecksum, $ean13WithoutChecksum);
    }

    /**
     * @test
     * @expectedException \Rebuy\EanIsbn\Exception\ConversionException
     */
    public function convert_rejects_identifier_without_ean13_conversion()
    {
        /** @var IdentifierInterface $mockIdentifier */
        $mockIdentifier = $this->getMock(IdentifierInterface::class);

        $this->converter->convert($mockIdentifier);
    }
}
