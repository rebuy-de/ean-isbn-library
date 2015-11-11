<?php

namespace Rebuy\EanIsbn\Tests\Parser;

use PHPUnit_Framework_TestCase;
use Rebuy\EanIsbn\Internal\ChecksumCalculatorInterface;
use Rebuy\EanIsbn\Parser\ParserInterface;

abstract class AbstractParserTest extends PHPUnit_Framework_TestCase
{
    private static $validChecksum = '0';

    /**
     * @var ParserInterface
     */
    protected $parser;

    /**
     * @return ChecksumCalculatorInterface
     */
    protected function getMockChecksumCalculator()
    {
        $checksumCalculator = $this->getMock(ChecksumCalculatorInterface::class);
        $checksumCalculator->expects($this->any())->method('calculate')->willReturn(self::$validChecksum);

        return $checksumCalculator;
    }
}
