<?php

namespace Rebuy\EanIsbn\Internal;

interface ChecksumCalculatorInterface
{
    /**
     * @param string $value
     * @return string
     */
    public function calculate($value);
}
