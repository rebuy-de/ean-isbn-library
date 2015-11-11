<?php

namespace Rebuy\EanIsbn\Tests\Converter;

use Rebuy\EanIsbn\Converter\ConverterInterface;
use Rebuy\EanIsbn\Identifier\IdentifierInterface;
use PHPUnit_Framework_TestCase;
use Rebuy\EanIsbn\Internal\ChecksumCalculatorInterface;

abstract class AbstractConverterTest extends PHPUnit_Framework_TestCase
{
    private static $validChecksum = '0';

    /**
     * @var ConverterInterface
     */
    protected $converter;

    /**
     * @test
     * @expectedException \Rebuy\EanIsbn\Exception\ConversionException
     */
    public function convert_rejects_identifier_type_without_conversion()
    {
        /** @var IdentifierInterface $mockIdentifier */
        $mockIdentifier = $this->getMock(IdentifierInterface::class);

        $this->converter->convert($mockIdentifier);
    }

    /**
     * @return ChecksumCalculatorInterface
     */
    protected function getMockChecksumCalculator()
    {
        $checksumCalculator = $this->getMock(ChecksumCalculatorInterface::class);
        $checksumCalculator->expects($this->any())->method('calculate')->willReturn(self::$validChecksum);

        return $checksumCalculator;
    }

    /**
     * @return string
     */
    protected function getValidChecksum()
    {
        return self::$validChecksum;
    }
}
