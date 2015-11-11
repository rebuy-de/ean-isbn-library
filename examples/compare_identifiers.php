<?php

include(__DIR__ . '/../vendor/autoload.php');

use Rebuy\EanIsbn\Converter\Converter;
use Rebuy\EanIsbn\Exception\ConversionException;
use Rebuy\EanIsbn\Exception\ParseException;
use Rebuy\EanIsbn\Parser\Parser;

$value1 = '978-0091956141';
$value2 = '0091956145';

function compareIdentifiers($value1, $value2)
{
    $parser = new Parser();
    $converter = new Converter();

    try {
        $identifier1 = $parser->parse($value1);
        $identifier2 = $parser->parse($value2);

        $identifiersAreEqual = $identifier1->equals($identifier2);

        try {
            $conversion = $converter->convert($identifier1);
            $identifiersAreConvertible = $conversion->equals($identifier2);
        } catch (ConversionException $exception) {
            $identifiersAreConvertible = false;
        }

        if ($identifiersAreEqual || $identifiersAreConvertible) {
            printf('Identifiers "%s" and "%s" refer to the same product' . PHP_EOL, $identifier1, $identifier2);
        } else {
            printf('Identifiers "%s" and "%s" refer to different products' . PHP_EOL, $identifier1, $identifier2);
        }
    } catch (ParseException $e) {
        printf($e->getMessage() . PHP_EOL);
    }
}

// prints 'Identifiers "9780091956141" and "0091956145" refer to the same product'
compareIdentifiers('978-0091956141', '0091956145');

// prints 'Identifiers "4017404018445" and "0091956145" refer to different products'
compareIdentifiers('4017404018445', '0091956145');
