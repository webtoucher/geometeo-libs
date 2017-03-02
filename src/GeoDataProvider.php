<?php

namespace webtoucher\geometeo\libs;

class GeoDataProvider
{
    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

    /**
     * @param float|Coordinate $latitude
     * @param float|Coordinate $longitude
     */
    public function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude instanceof Coordinate ? $latitude->decimal : $latitude;
        $this->longitude = $longitude instanceof Coordinate ? $longitude->decimal : $longitude;
    }

    /**
     * @param Calculator $calculator
     * @param array $inputValuesGrid
     * @return array
     */
    public function calculate(Calculator $calculator, $inputValuesGrid)
    {
        $outputValuesGrid = [];
        foreach ($inputValuesGrid as $date => $inputValues) {
            $outputValuesGrid[$date] = $calculator->calculate($this, $date, $inputValues);
        }
        return $outputValuesGrid;
    }
}
