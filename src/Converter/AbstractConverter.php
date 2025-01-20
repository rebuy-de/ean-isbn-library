<?php

namespace Rebuy\EanIsbn\Converter;

use Rebuy\EanIsbn\Internal\ChecksumCalculatorInterface;

abstract class AbstractConverter implements ConverterInterface
{
    protected static $ean8ToEan13Prefix = '00000';

    protected static $isbn10ToEan13Prefix = '978';

    /**
     * @var ChecksumCalculatorInterface
     */
    protected $checksumCalculator;

    /**
     * @param ChecksumCalculatorInterface $checksumCalculator
     */
    public function __construct(?ChecksumCalculatorInterface $checksumCalculator = null)
    {
        $this->checksumCalculator = $checksumCalculator;
    }

    /**
     * @param string $prefix
     * @param string $value
     * @return bool
     */
    protected function prefixMatches($prefix, $value)
    {
        return substr($value, 0, strlen($prefix)) === $prefix;
    }
}
