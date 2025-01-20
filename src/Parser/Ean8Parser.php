<?php

namespace Rebuy\EanIsbn\Parser;

use Rebuy\EanIsbn\Identifier\Ean8;
use Rebuy\EanIsbn\Internal\ChecksumCalculatorInterface;
use Rebuy\EanIsbn\Internal\Ean13ChecksumCalculator;

class Ean8Parser extends AbstractParser
{
    private static $ean8ToEan13Prefix = '00000';

    public function __construct(?ChecksumCalculatorInterface $checksumCalculator = null)
    {
        parent::__construct($checksumCalculator ?: new Ean13ChecksumCalculator());
    }

    public function getTypeName()
    {
        return Ean8::NAME;
    }

    protected function getFormat()
    {
        return '/^(?:\d-?){7}\d$/';
    }

    protected function calculateChecksum($prefix)
    {
        return $this->checksumCalculator->calculate(self::$ean8ToEan13Prefix . $prefix);
    }

    protected function createIdentifier($value)
    {
        return new Ean8($value);
    }
}
