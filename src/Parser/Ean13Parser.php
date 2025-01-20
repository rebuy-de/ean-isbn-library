<?php

namespace Rebuy\EanIsbn\Parser;

use Rebuy\EanIsbn\Identifier\Ean13;
use Rebuy\EanIsbn\Internal\ChecksumCalculatorInterface;
use Rebuy\EanIsbn\Internal\Ean13ChecksumCalculator;

class Ean13Parser extends AbstractParser
{
    public function __construct(?ChecksumCalculatorInterface $checksumCalculator = null)
    {
        parent::__construct($checksumCalculator ?: new Ean13ChecksumCalculator());
    }

    public function getTypeName()
    {
        return Ean13::NAME;
    }

    protected function getFormat()
    {
        return '/^(?:\d-?){12}\d$/';
    }

    protected function calculateChecksum($prefix)
    {
        return $this->checksumCalculator->calculate($prefix);
    }

    protected function createIdentifier($value)
    {
        return new Ean13($value);
    }
}
