<?php

use Rebuy\EanIsbn\Internal\Isbn10ChecksumCalculator;

class Isbn10ChecksumCalculatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider provideIsbn10Checksums
     *
     * @param $value
     * @param $checksum
     */
    public function calculate_should_return_valid_checksum($value, $checksum)
    {
        $isbn10ChecksumCalculator = new Isbn10ChecksumCalculator();

        $this->assertEquals($checksum, $isbn10ChecksumCalculator->calculate($value));
    }

    /**
     * @return array
     */
    public function provideIsbn10Checksums()
    {
        return [
            ['068484328', '5'],
            ['999215810', '7'],
            ['097522980', 'X'],
            ['349919967', 'X'],
        ];
    }
}
