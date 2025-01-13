<?php

namespace Rebuy\EanIsbn\Converter;

use Rebuy\EanIsbn\Exception\ConversionException;
use Rebuy\EanIsbn\Identifier\Ean13;
use Rebuy\EanIsbn\Identifier\IdentifierInterface;
use Rebuy\EanIsbn\Identifier\Isbn10;
use Rebuy\EanIsbn\Internal\ChecksumCalculatorInterface;
use Rebuy\EanIsbn\Internal\Isbn10ChecksumCalculator;

class Isbn10Converter extends AbstractConverter
{
    public function __construct(?ChecksumCalculatorInterface $checksumCalculator = null)
    {
        parent::__construct($checksumCalculator ?: new Isbn10ChecksumCalculator());
    }

    /**
     * @param IdentifierInterface $identifier
     *
     * @return Isbn10|null
     * @throws ConversionException
     */
    public function convert(IdentifierInterface $identifier)
    {
        if ($identifier instanceof Ean13 && $this->prefixMatches(self::$isbn10ToEan13Prefix, $identifier)) {
            return $this->convertEan13ToIsbn10($identifier);
        }

        throw new ConversionException('"%s" cannot be converted to %s', $identifier, Isbn10::NAME);
    }

    /**
     * @param Ean13 $ean13
     *
     * @return Isbn10
     */
    private function convertEan13ToIsbn10(Ean13 $ean13)
    {
        $isbn10WithoutChecksum = substr($ean13->getValue(), strlen(self::$isbn10ToEan13Prefix), -1);
        $isbn10Checksum = $this->checksumCalculator->calculate($isbn10WithoutChecksum);

        return new Isbn10($isbn10WithoutChecksum . $isbn10Checksum);
    }
}
