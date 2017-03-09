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
    use \webtoucher\geometeo\libs\Coordinate;
```

Create and configure data provider for selected geoposition.

```php
    $provider = new GeoDataProvider(55.012207, 83.289468, 'Asia/Novosibirsk');
```
or

```php
    $provider = new GeoDataProvider(
        Coordinate::fromDms(55, 0, 43.945199999987, Coordinate::NORTH),
        Coordinate::fromDms(83, 17, 22.084799999998, Coordinate::EAST),
        'Asia/Novosibirsk'
    );
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
    $calculator = new SunCalculator(SunCalculator::AZIMUTH|SunCalculator::ALTITUDE);
    $outputValuesGrid = $provider->calculate($calculator, $inputValuesGrid);

    // $outputValuesGrid:
    // [
    //     '2017-03-02 19:00:00' => [
    //         SunCalculator::AZIMUTH => 257.89361108248,
    //         SunCalculator::ALTITUDE => -0.36968324076901,
    //     ],
    //     '2017-03-02 19:01:00' => [
    //         SunCalculator::AZIMUTH => 258.09820089334,
    //         SunCalculator::ALTITUDE => -0.50989896273262,
    //     ],
    //     '2017-03-02 19:02:00' => [
    //         SunCalculator::AZIMUTH => 258.30272277877,
    //         SunCalculator::ALTITUDE => -0.65022023277039,
    //     ],
    //     '2017-03-02 19:03:00' => [
    //         SunCalculator::AZIMUTH => 258.50717913747,
    //         SunCalculator::ALTITUDE => -0.7906452287774,
    //     ],
    //     '2017-03-02 19:04:00' => [
    //         SunCalculator::AZIMUTH => 258.71157237265,
    //         SunCalculator::ALTITUDE => -0.93117213026396,
    //     ],
    // ];
```

## Support

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/webtoucher/geometeo-libs/issues).