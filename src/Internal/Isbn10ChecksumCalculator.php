<?php

namespace Rebuy\EanIsbn\Internal;

class Isbn10ChecksumCalculator implements ChecksumCalculatorInterface
{
    public function calculate($value)
    {
        $weightedSum = 0;
        $weight = 10;

        foreach (str_split($value) as $digit) {
            $weightedSum += $weight * intval($digit);
            $weight--;
        }

        $checksum = (11 - ($weightedSum % 11)) % 11;

        if ($checksum === 10) {
            return 'X';
        }

        return strval($checksum);
    }
}
