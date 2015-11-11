<?php

namespace Rebuy\EanIsbn\Tests\Parser;

use Rebuy\EanIsbn\Identifier\Ean13;
use Rebuy\EanIsbn\Parser\Ean13Parser;

class Ean13ParserTest extends AbstractParserTest
{
    public function setUp() {
        $this->parser = new Ean13Parser($this->getMockChecksumCalculator());
    }

    /**
     * @test
     * @dataProvider \Rebuy\EanIsbn\Tests\Helper\IdentifierProvider::provideValidEan13
     * @param string $value
     */
    public function parse_returns_valid_ean13($value)
    {
        $identifier = $this->parser->parse($value);

        $this->assertInstanceOf(Ean13::class, $identifier);
        $this->assertEquals($identifier, $identifier->getValue());
    }

    /**
     * @test
     * @dataProvider \Rebuy\EanIsbn\Tests\Helper\IdentifierProvider::provideEan13WithInvalidChecksums
     * @param string $value
     * @expectedException \Rebuy\EanIsbn\Exception\ParseException
     */
    public function parse_rejects_identifier_with_invalid_checksum($value)
    {
        $this->parser->parse($value);
    }

    /**
     * @test
     * @dataProvider \Rebuy\EanIsbn\Tests\Helper\IdentifierProvider::provideEan13WithInvalidFormatting
     * @param string $value
     * @expectedException \Rebuy\EanIsbn\Exception\ParseException
     */
    public function parse_rejects_ean13_with_invalid_formatting($value)
    {
        $this->parser->parse($value);
    }

    /**
     * @test
     * @dataProvider \Rebuy\EanIsbn\Tests\Helper\IdentifierProvider::provideEan13WithInvalidLength
     * @param string $value
     * @expectedException \Rebuy\EanIsbn\Exception\ParseException
     */
    public function parse_rejects_identifier_with_invalid_length($value)
    {
        $this->parser->parse($value);
    }
}
