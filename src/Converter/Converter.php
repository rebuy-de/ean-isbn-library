<?php

namespace Rebuy\EanIsbn\Converter;

use Rebuy\EanIsbn\Exception\ConversionException;
use Rebuy\EanIsbn\Identifier\Ean13;
use Rebuy\EanIsbn\Identifier\Ean8;
use Rebuy\EanIsbn\Identifier\IdentifierInterface;
use Rebuy\EanIsbn\Identifier\Isbn10;

class Converter extends AbstractConverter
{
    /**
     * @var ConverterInterface[][]
     */
    private $converterMap;

    /**
     * @param ConverterInterface[][] $converterMap
     */
    public function __construct(array $converterMap = null)
    {
        parent::__construct();

        $this->converterMap = $converterMap ?: [
            Ean8::class => [new Ean13Converter()],
            Ean13::class => [new Ean8Converter(), new Isbn10Converter()],
            Isbn10::class => [new Ean13Converter()]
        ];
    }

    public function convert(IdentifierInterface $identifier)
    {
        if (isset($this->converterMap[get_class($identifier)])) {
            foreach ($this->converterMap[get_class($identifier)] as $converter) {
                try {
                    return $converter->convert($identifier);
                } catch (ConversionException $exception) {
                    continue;
                }
            }
        }

        throw new ConversionException('There is no conversion for "%s"', $identifier);
    }
}
