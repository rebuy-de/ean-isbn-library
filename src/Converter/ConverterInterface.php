<?php

namespace Rebuy\EanIsbn\Converter;

use Rebuy\EanIsbn\Identifier\IdentifierInterface;

interface ConverterInterface
{
    /**
     * @param IdentifierInterface $identifier
     * @return IdentifierInterface|null
     */
    public function convert(IdentifierInterface $identifier);
}
