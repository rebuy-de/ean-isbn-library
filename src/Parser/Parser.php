<?php

namespace Rebuy\EanIsbn\Parser;

use Rebuy\EanIsbn\Exception\ParseException;

class Parser implements ParserInterface
{
    /**
     * @var ParserInterface[] $parsers
     */
    private $parsers;

    /**
     * @param ParserInterface[] $parsers
     */
    public function __construct(array $parsers = null)
    {
        $this->parsers = $parsers ?: [
            new Ean8Parser(),
            new Ean13Parser(),
            new Isbn10Parser(),
        ];
    }

    public function parse($value)
    {
        foreach ($this->parsers as $parser) {
            try {
                return $parser->parse($value);
            } catch (ParseException $exception) {
                continue;
            }
        }

        throw new ParseException('"%s" couldn\'t be parsed', $value);
    }
}
