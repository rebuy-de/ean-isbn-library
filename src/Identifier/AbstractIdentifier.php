<?php

namespace Rebuy\EanIsbn\Identifier;

abstract class AbstractIdentifier implements IdentifierInterface
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param IdentifierInterface $identifier
     * @return bool
     */
    public function equals(IdentifierInterface $identifier)
    {
        return $this->getValue() === $identifier->getValue();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getValue();
    }
}
