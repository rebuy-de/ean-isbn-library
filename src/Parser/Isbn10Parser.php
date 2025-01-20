<?php

namespace Rebuy\EanIsbn\Parser;

use Rebuy\EanIsbn\Identifier\Isbn10;
use Rebuy\EanIsbn\Internal\ChecksumCalculatorInterface;
use Rebuy\EanIsbn\Internal\Isbn10ChecksumCalculator;

class Isbn10Parser extends AbstractParser
{
    public function __construct(?ChecksumCalculatorInterface $checksumCalculator = null)
    {
        parent::__construct($checksumCalculator ?: new Isbn10ChecksumCalculator());
    }

    public function getTypeName()
    {
        return Isbn10::NAME;
    }

    protected function getFormat()
    {
        return '/^(?:\d-?){9}[\d|X]$/';
    }

    protected function calculateChecksum($prefix)
    {
        return $this->checksumCalculator->calculate($prefix);
    }

    protected function createIdentifier($value)
    {
        return new Isbn10($value);
    }
}
