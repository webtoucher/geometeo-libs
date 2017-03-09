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
     * @var \DateTimeZone
     */
    private $dataTimeZone;

    /**
     * @param float|Coordinate $latitude
     * @param float|Coordinate $longitude
     * @param string $dataTimeZone
     */
    public function __construct($latitude, $longitude, $dataTimeZone = null)
    {
        $this->latitude = $latitude instanceof Coordinate ? $latitude->decimal : $latitude;
        $this->longitude = $longitude instanceof Coordinate ? $longitude->decimal : $longitude;
        if ($dataTimeZone) {
            $this->dataTimeZone = new \DateTimeZone($dataTimeZone);
        }
    }

    /**
     * Returns calculated params time grid.
     *
     * @param Calculator $calculator
     * @param array $inputValuesGrid
     * @return array
     */
    public function calculate(Calculator $calculator, $inputValuesGrid)
    {
        $outputValuesGrid = [];
        foreach ($inputValuesGrid as $date => $inputValues) {
            $outputValuesGrid[$date] = $calculator->calculate($this, new \DateTime($date, $this->dataTimeZone), $inputValues);
        }
        return $outputValuesGrid;
    }

    /**
     * Returns latitude.
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Returns longitude.
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
}
