<?php

include(__DIR__ . '/../vendor/autoload.php');

use Rebuy\EanIsbn\Converter\Isbn10Converter;
use Rebuy\EanIsbn\Exception\EanIsbnException;
use Rebuy\EanIsbn\Parser\Ean13Parser;

function convertEan13ToIsbn10($value)
{
    $ean13Parser = new Ean13Parser();
    $isbn10Converter = new Isbn10Converter();

    try {
        $ean13 = $ean13Parser->parse($value);
        $isbn10 = $isbn10Converter->convert($ean13);

        printf('The ISBN-10 conversion of "%s" is "%s"' . PHP_EOL, $ean13, $isbn10);
    } catch (EanIsbnException $e) {
        printf($e->getMessage() . PHP_EOL);
    }
}

// prints 'The ISBN-10 conversion of "9780091956141" is "0091956145"'
convertEan13ToIsbn10('978-0091956141');

// prints '"4017404018445" cannot be converted to ISBN-10'
convertEan13ToIsbn10('4017404018445');
