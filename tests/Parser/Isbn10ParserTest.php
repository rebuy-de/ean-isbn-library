<?php

namespace Rebuy\EanIsbn\Tests\Parser;

use Rebuy\EanIsbn\Identifier\Isbn10;
use Rebuy\EanIsbn\Parser\Isbn10Parser;

class Isbn10ParserTest extends AbstractParserTest
{
    public function setUp()
    {
        $this->parser = new Isbn10Parser($this->getMockChecksumCalculator());
    }

    /**
     * @test
     * @dataProvider \Rebuy\EanIsbn\Tests\Helper\IdentifierProvider::provideValidIsbn10
     * @param string $value
     */
    public function parse_returns_valid_isbn10($value)
    {
        $identifier = $this->parser->parse($value);

        $this->assertInstanceOf(Isbn10::class, $identifier);
        $this->assertEquals($identifier, $identifier->getValue());
    }

    /**
     * @test
     * @dataProvider \Rebuy\EanIsbn\Tests\Helper\IdentifierProvider::provideIsbn10WithInvalidChecksums
     * @param string $value
     * @expectedException \Rebuy\EanIsbn\Exception\ParseException
     */
    public function parse_rejects_identifier_with_invalid_checksum($value)
    {
        $this->parser->parse($value);
    }

    /**
     * @test
     * @dataProvider \Rebuy\EanIsbn\Tests\Helper\IdentifierProvider::provideIsbn10WithInvalidFormatting
     * @param string $value
     * @expectedException \Rebuy\EanIsbn\Exception\ParseException
     */
    public function parse_rejects_isbn10_with_invalid_formatting($value)
    {
        $this->parser->parse($value);
    }

    /**
     * @test
     * @dataProvider \Rebuy\EanIsbn\Tests\Helper\IdentifierProvider::provideIsbn10WithInvalidLength
     * @param string $value
     * @expectedException \Rebuy\EanIsbn\Exception\ParseException
     */
    public function parse_rejects_identifier_with_invalid_length($value)
    {
        $this->parser->parse($value);
    }
}
