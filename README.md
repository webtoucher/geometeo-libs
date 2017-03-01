# GeoMeteo: Libs
Libraries for GeoMeteo or another application.

[![Latest Stable Version](https://poser.pugx.org/webtoucher/geometeo-libs/v/stable)](https://packagist.org/packages/webtoucher/geometeo-libs)
[![Total Downloads](https://poser.pugx.org/webtoucher/geometeo-libs/downloads)](https://packagist.org/packages/webtoucher/geometeo-libs)
[![Daily Downloads](https://poser.pugx.org/webtoucher/geometeo-libs/d/daily)](https://packagist.org/packages/webtoucher/geometeo-libs)
[![Latest Unstable Version](https://poser.pugx.org/webtoucher/geometeo-libs/v/unstable)](https://packagist.org/packages/webtoucher/geometeo-libs)
[![License](https://poser.pugx.org/webtoucher/geometeo-libs/license)](https://packagist.org/packages/webtoucher/geometeo-libs)

## Installation

The preferred way to install this library is through [composer](http://getcomposer.org/download/).

Either run

```
$ php composer.phar require webtoucher/geometeo-libs "*"
```

or add

```
"webtoucher/geometeo-libs": "*"
```

to the ```require``` section of your `composer.json` file.

## Usage

```php
    use \webtoucher\geometeo\libs\GeoDataProvider;
    use \webtoucher\geometeo\libs\SunCalculator;
```

Create and configure data provider for selected geoposition.

```php
    $provider = new GeoDataProvider(486010.25, 4221916.21);
```

Then you can calculate needed data with one of calculators and time grid.

```php
    $inputValuesGrid = [
        '2017-03-02 19:00:00' => [],
        '2017-03-02 19:01:00' => [],
        '2017-03-02 19:02:00' => [],
        '2017-03-02 19:03:00' => [],
        '2017-03-02 19:04:00' => [],
    ];
    $sunPower = $provider->calculate(new SunCalculator(SunCalculator::POWER), $inputValuesGrid);

    // Result:
    // $sunPower = [
    //     '2017-03-02 19:00:00' => [
    //         SunCalculator::POWER => 50,
    //     ],
    //     '2017-03-02 19:01:00' => [
    //         SunCalculator::POWER => 50,
    //     ],
    //     '2017-03-02 19:02:00' => [
    //         SunCalculator::POWER => 50,
    //     ],
    //     '2017-03-02 19:03:00' => [
    //         SunCalculator::POWER => 50,
    //     ],
    //     '2017-03-02 19:04:00' => [
    //         SunCalculator::POWER => 50,
    //     ],
    // ];
```

## Support

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/webtoucher/geometeo-libs/issues).