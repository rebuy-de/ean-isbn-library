<?php

namespace Rebuy\EanIsbn\Converter;

use Rebuy\EanIsbn\Exception\ConversionException;
use Rebuy\EanIsbn\Identifier\Ean13;
use Rebuy\EanIsbn\Identifier\Ean8;
use Rebuy\EanIsbn\Identifier\IdentifierInterface;
use Rebuy\EanIsbn\Identifier\Isbn10;
use Rebuy\EanIsbn\Internal\ChecksumCalculatorInterface;
use Rebuy\EanIsbn\Internal\Ean13ChecksumCalculator;

class Ean13Converter extends AbstractConverter
{
    public function __construct(ChecksumCalculatorInterface $checksumCalculator = null)
    {
        parent::__construct($checksumCalculator ?: new Ean13ChecksumCalculator());
    }

    /**
     * @param IdentifierInterface $identifier
     *
     * @return Ean13|null
     * @throws ConversionException
     */
    public function convert(IdentifierInterface $identifier)
    {
        if ($identifier instanceof Ean8) {
            return new Ean13(self::$ean8ToEan13Prefix . $identifier->getValue());
        }

        if ($identifier instanceof Isbn10) {
            return $this->convertIsbn10ToEan13($identifier);
        }

        throw new ConversionException('"%s" cannot be converted to %s', $identifier, Ean13::NAME);
    }

    /**
     * @param Isbn10 $isbn10
     *
     * @return Ean13
     */
    private function convertIsbn10ToEan13(Isbn10 $isbn10)
    {
        $ean13WithoutChecksum = self::$isbn10ToEan13Prefix . substr($isbn10->getValue(), 0, -1);
        $ean13Checksum = $this->checksumCalculator->calculate($ean13WithoutChecksum);

        return new Ean13($ean13WithoutChecksum . $ean13Checksum);
    }
}
