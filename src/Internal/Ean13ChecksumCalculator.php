<?php

namespace Rebuy\EanIsbn\Internal;

class Ean13ChecksumCalculator implements ChecksumCalculatorInterface
{
    public function calculate($value)
    {
        $weightedSum = 0;

        foreach (str_split($value) as $key => $digit) {
            $weight = $key % 2 === 0 ? 1 : 3;
            $weightedSum += $weight * intval($digit);
        }

        $checksum = (10 - ($weightedSum % 10)) % 10;

        return strval($checksum);
    }
}
