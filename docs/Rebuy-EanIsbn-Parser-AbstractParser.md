Rebuy\EanIsbn\Parser\AbstractParser
===============






* Class name: AbstractParser
* Namespace: Rebuy\EanIsbn\Parser
* This is an **abstract** class
* This class implements: [Rebuy\EanIsbn\Parser\ParserInterface](Rebuy-EanIsbn-Parser-ParserInterface.md)






Methods
-------


### __construct

    mixed Rebuy\EanIsbn\Parser\AbstractParser::__construct(\Rebuy\EanIsbn\Internal\ChecksumCalculatorInterface $checksumCalculator)





* Visibility: **public**


#### Arguments
* $checksumCalculator **Rebuy\EanIsbn\Internal\ChecksumCalculatorInterface**



### getTypeName

    string Rebuy\EanIsbn\Parser\AbstractParser::getTypeName()





* Visibility: **public**
* This method is **abstract**.




### parse

    \Rebuy\EanIsbn\Identifier\AbstractIdentifier Rebuy\EanIsbn\Parser\ParserInterface::parse(string $value)





* Visibility: **public**
* This method is defined by [Rebuy\EanIsbn\Parser\ParserInterface](Rebuy-EanIsbn-Parser-ParserInterface.md)


#### Arguments
* $value **string**


