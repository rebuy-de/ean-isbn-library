<?php

namespace Rebuy\EanIsbn\Tests\Helper;

use AppendIterator;
use Closure;
use Generator;
use ReverseRegex\Lexer;
use ReverseRegex\Random\GeneratorInterface;
use ReverseRegex\Random\SimpleRandom;
use ReverseRegex\Parser;
use ReverseRegex\Generator\Scope;

class IdentifierProvider
{
    private static $artifacts = ['--', ' ', 'A'];
    private static $validChecksum = '0';
    private static $invalidChecksum = '1';

    private static $iterations = 10;

    private static $generator;

    /**
     * @return Generator
     */
    public static function provideValidEan13()
    {
        return self::provideIdentifiers(13);
    }

    /**
     * @return Generator
     */
    public static function provideEan13WithInvalidChecksums()
    {
        return self::provideIdentifiers(13, false);
    }

    /**
     * @return Generator
     */
    public static function provideEan13WithInvalidFormatting()
    {
        return self::insertRandomArtifacts(self::provideIdentifiers(13));
    }

    /**
     * @return Generator
     */
    public static function provideEan13WithInvalidLength()
    {
        $iterator = new AppendIterator();
        $iterator->append(self::provideIdentifierLengthRange(1, 12));
        $iterator->append(self::provideIdentifierLengthRange(14, 15));

        return $iterator;
    }

    /**
     * @return Generator
     */
    public static function provideValidIsbn10()
    {
        return self::provideIdentifiers(10);
    }

    /**
     * @return Generator
     */
    public static function provideIsbn10WithInvalidChecksums()
    {
        return self::provideIdentifiers(10, false);
    }

    /**
     * @return Generator
     */
    public static function provideIsbn10WithInvalidFormatting()
    {
        return self::insertRandomArtifacts(self::provideIdentifiers(10));
    }

    /**
     * @return Generator
     */
    public static function provideIsbn10WithInvalidLength()
    {
        $iterator = new AppendIterator();
        $iterator->append(self::provideIdentifierLengthRange(1, 9));
        $iterator->append(self::provideIdentifierLengthRange(11, 15));

        return $iterator;
    }

    /**
     * @return Generator
     */
    public static function provideValidEan8()
    {
        return self::provideIdentifiers(8);
    }

    /**
     * @return Generator
     */
    public static function provideEan8WithInvalidChecksums()
    {
        return self::provideIdentifiers(8, false);
    }

    /**
     * @return Generator
     */
    public static function provideEan8WithInvalidFormatting()
    {
        return self::insertRandomArtifacts(self::provideIdentifiers(8));
    }

    /**
     * @return Generator
     */
    public static function provideEan8WithInvalidLength()
    {
        $iterator = new AppendIterator();
        $iterator->append(self::provideIdentifierLengthRange(1, 7));
        $iterator->append(self::provideIdentifierLengthRange(9, 15));

        return $iterator;
    }

    /**
     * @param Generator $values
     *
     * @return Closure
     */
    protected static function insertRandomArtifacts(Generator $values)
    {
        foreach ($values as $value) {
            $artifact = self::$artifacts[rand(0, count(self::$artifacts) - 1)];
            $artifactPosition = rand(0, strlen($value[0]));

            yield [substr_replace($value[0], $artifact, $artifactPosition, 0)];
        }
    }

    /**
     * @param string $pattern
     *
     * @return string
     * @throws \ReverseRegex\Exception
     */
    private static function getRandomString($pattern)
    {
        $parser = new Parser(new Lexer($pattern), new Scope(), new Scope());
        $result = '';
        $parser->parse()->getResult()->generate($result, self::getGenerator());

        return $result;
    }

    /**
     * @param int $length
     * @param bool $isValid
     *
     * @return \Generator
     */
    private static function provideIdentifiers($length, $isValid = true)
    {
        $suffix = $isValid ? self::$validChecksum : self::$invalidChecksum;
        foreach (range(1, self::$iterations) as $iteration) {
            $value = self::getRandomString(sprintf('(\d-?){%d}', $length - 1)) . $suffix;

            yield [$value];
        }
    }

    /**
     * @param int $minLength
     * @param int $maxLength
     *
     * @return \Generator
     */
    private static function provideIdentifierLengthRange($minLength, $maxLength)
    {
        foreach (range($minLength, $maxLength) as $length) {
            foreach(self::provideIdentifiers($length) as $value) {
                yield $value;
            }
        }
    }

    /**
     * @return GeneratorInterface
     */
    private static function getGenerator()
    {
        if (is_null(self::$generator)) {
            srand(0);
            self::$generator = new SimpleRandom(0);
        }

        return self::$generator;
    }
}
