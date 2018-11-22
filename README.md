# reBuy EAN / ISBN Library

A PHP library for validating and converting EAN and ISBN identifiers
licensed under the [MIT license](LICENSE.md).

## Installation

To use the library you need PHP 5.6 and [Composer](https://getcomposer.org/).
Add the following entry to your `composer.json`.

```shell
composer require rebuy-de/ean-isbn-library
```

## Usage

The core of the library are identifier objects representing valid EAN-13, EAN-8, or ISBN-10 identifiers.
Identifier objects can be created using a parser which validates and normalizes the identifier string.

```php
$parser = new Parser();
$identifier = $parser->parse('978-0091956141');

echo $identifier; // will print '9780091956141'
```

Once you have an identifier object, you can convert it into an alternate representation if available.

```php
$converter = new Converter();
$conversion = $converter->convert($identifier);
echo $conversion; // will print '0091956145'
```

Both parsers and converters will throw exceptions if the action can’t be performed.
Go to [examples](/examples) for complete executable examples and [docs](docs/ApiIndex.md) for a full API reference.

## Troubleshooting

* If you come across errors or bugs please feel free to report them by
opening an issue [here](https://github.com/rebuy-de/ean-isbn-library/issues)
but please check open issues before you do in case someone already created one.

## Contributing

Feel free to [open an issue](https://github.com/rebuy-de/ean-isbn-library/issues) if you find
bugs or if you're missing functionality that should be included.

Pull requests for additional features are welcome as long as
they fit the requirements detailed under [CONTRIBUTING](CONTRIBUTING.md).
