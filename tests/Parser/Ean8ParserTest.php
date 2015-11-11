<?php

namespace Rebuy\EanIsbn\Tests\Parser;

use Rebuy\EanIsbn\Identifier\Ean8;
use Rebuy\EanIsbn\Parser\Ean8Parser;

class Ean8ParserTest extends AbstractParserTest
{
    public function setUp()
    {
        $this->parser = new Ean8Parser($this->getMockChecksumCalculator());
    }

    /**
     * @test
     * @dataProvider \Rebuy\EanIsbn\Tests\Helper\IdentifierProvider::provideValidEan8
     * @param string $value
     */
    public function parse_returns_valid_ean8($value)
    {
        $identifier = $this->parser->parse($value);

        $this->assertInstanceOf(Ean8::class, $identifier);
        $this->assertEquals(str_replace('-', '', $value), $identifier->getValue());
    }

    /**
     * @test
     * @dataProvider \Rebuy\EanIsbn\Tests\Helper\IdentifierProvider::provideEan8WithInvalidChecksums
     * @param string $value
     * @expectedException \Rebuy\EanIsbn\Exception\ParseException
     */
    public function parse_rejects_identifier_with_invalid_checksum($value)
    {
        $this->parser->parse($value);
    }

    /**
     * @test
     * @dataProvider \Rebuy\EanIsbn\Tests\Helper\IdentifierProvider::provideEan8WithInvalidFormatting
     * @param string $value
     * @expectedException \Rebuy\EanIsbn\Exception\ParseException
     */
    public function parse_rejects_ean13_with_invalid_formatting($value)
    {
        $this->parser->parse($value);
    }

    /**
     * @test
     * @dataProvider \Rebuy\EanIsbn\Tests\Helper\IdentifierProvider::provideEan8WithInvalidLength
     * @param string $value
     * @expectedException \Rebuy\EanIsbn\Exception\ParseException
     */
    public function parse_rejects_identifier_with_invalid_length($value)
    {
        $this->parser->parse($value);
    }
}
