<?php

namespace Rebuy\EanIsbn\Converter;

use Rebuy\EanIsbn\Exception\ConversionException;
use Rebuy\EanIsbn\Identifier\Ean13;
use Rebuy\EanIsbn\Identifier\Ean8;
use Rebuy\EanIsbn\Identifier\IdentifierInterface;

class Ean8Converter extends AbstractConverter
{
    /**
     * @param IdentifierInterface $identifier
     *
     * @return Ean8|null
     * @throws ConversionException
     */
    public function convert(IdentifierInterface $identifier)
    {
        if ($identifier instanceof Ean13 && $this->prefixMatches(self::$ean8ToEan13Prefix, $identifier)) {
            return new Ean8(substr($identifier->getValue(), strlen(self::$ean8ToEan13Prefix)));
        }

        throw new ConversionException('"%s" cannot be converted to %s', $identifier, Ean8::NAME);
    }
}
