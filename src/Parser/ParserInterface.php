<?php

namespace Rebuy\EanIsbn\Parser;

use Rebuy\EanIsbn\Identifier\AbstractIdentifier;

interface ParserInterface
{
    /**
     * @param string $value
     * @return AbstractIdentifier
     */
    public function parse($value);
}
