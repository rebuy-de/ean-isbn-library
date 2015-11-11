<?php

namespace Rebuy\EanIsbn\Identifier;

interface IdentifierInterface
{
    /**
     * @return string
     */
    public function getValue();

    /**
     * @param IdentifierInterface $identifier
     * @return bool
     */
    public function equals(IdentifierInterface $identifier);

    /**
     * @return string
     */
    public function __toString();
}
