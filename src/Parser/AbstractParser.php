<?php

namespace Rebuy\EanIsbn\Parser;

use Rebuy\EanIsbn\Exception\ParseException;
use Rebuy\EanIsbn\Internal\ChecksumCalculatorInterface;

abstract class AbstractParser implements ParserInterface
{
    /**
     * @var ChecksumCalculatorInterface
     */
    protected $checksumCalculator;

    /**
     * @param ChecksumCalculatorInterface $checksumCalculator
     */
    public function __construct(ChecksumCalculatorInterface $checksumCalculator = null)
    {
        $this->checksumCalculator = $checksumCalculator;
    }

    /**
     * @return string
     */
    abstract public function getTypeName();

    /**
     * @return string
     */
    abstract protected function getFormat();

    /**
     * @param string $prefix
     * @return string
     */
    abstract protected function calculateChecksum($prefix);

    /**
     * @param string $value
     * @return string
     */
    abstract protected function createIdentifier($value);

    public function parse($value)
    {
        if ($this->isValid($value)) {
            return $this->createIdentifier($this->normalize($value));
        }

        throw new ParseException('"%s" is not a valid %s', $value, $this->getTypeName());
    }

    /**
     * @param $value
     * @return bool
     */
    private function isValid($value)
    {
        if (!preg_match($this->getFormat(), $value)) {
            return false;
        }

        $value = $this->normalize($value);

        list($prefix, $checksum) = str_split($value, strlen($value) - 1);
        if ($checksum !== $this->calculateChecksum($prefix)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $value
     * @return string
     */
    private function normalize($value)
    {
        $value = str_replace('-', '', $value);

        return $value;
    }
}
