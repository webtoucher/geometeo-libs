<?php

namespace webtoucher\geometeo\libs;

class GeoDataProvider
{
    /**
     * @var number
     */
    private $latitude;

    /**
     * @var number
     */
    private $longitude;

    /**
     * @param number|string $latitude
     * @param $longitude
     */
    public function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
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
