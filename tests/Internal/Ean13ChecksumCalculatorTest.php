<?php

use Rebuy\EanIsbn\Internal\Ean13ChecksumCalculator;

class Ean13ChecksumCalculatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider provideEan13Checksums
     *
     * @param string $value
     * @param string $checksum
     */
    public function calculate_should_return_valid_checksum($value, $checksum)
    {
        $ean13ChecksumCalculator = new Ean13ChecksumCalculator();

        $this->assertEquals($checksum, $ean13ChecksumCalculator->calculate($value));
    }

    /**
     * @return array
     */
    public function provideEan13Checksums()
    {
        return [
            ['978316148410', '0'],
            ['978381052395', '2'],
            ['503094011238', '4'],
            ['978342310177', '6'],
            ['004549652556', '9'],
        ];
    }
}
