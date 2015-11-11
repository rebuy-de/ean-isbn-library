<?php

namespace Rebuy\EanIsbn\Tests\Parser;

use Rebuy\EanIsbn\Exception\ParseException;
use Rebuy\EanIsbn\Parser\Parser;
use Rebuy\EanIsbn\Parser\ParserInterface;

class ParserTest extends AbstractParserTest
{
    public function setUp()
    {
        $this->parser = new Parser();
    }

    /**
     * @test
     * @expectedException \Rebuy\EanIsbn\Exception\ParseException
     */
    public function parse_tries_all_specialized_parsers_before_throwing()
    {
        $value = 'VALUE';

        $exception = new ParseException('');

        $specializedParser1 = $this->getMock(ParserInterface::class);
        $specializedParser1->expects($this->once())->method('parse')->with($value)->willThrowException($exception);
        $specializedParser2 = $this->getMock(ParserInterface::class);
        $specializedParser2->expects($this->once())->method('parse')->with($value)->willThrowException($exception);

        $parser = new Parser([$specializedParser1, $specializedParser2]);
        $parser->parse($value);
    }

    /**
     * @test
     */
    public function parse_passes_identifier_from_specialized_parser()
    {
        $value = 'VALUE';
        $expectedIdentifier = 'IDENTIFIER';

        $specializedParser = $this->getMock(ParserInterface::class);
        $specializedParser->expects($this->once())->method('parse')->with($value)->willReturn($expectedIdentifier);

        $parser = new Parser([$specializedParser]);
        $identifier = $parser->parse($value);

        $this->assertEquals($expectedIdentifier, $identifier);
    }
}
