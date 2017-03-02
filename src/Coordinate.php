<?php

namespace webtoucher\geometeo\libs;

class Coordinate
{
    const NORTH = 1 << 0;     // 000001

    const SOUTH = 1 << 1;     // 000010

    const WEST = 1 << 2;      // 000100

    const EAST = 1 << 3;      // 001000

    const LATITUDE = 1 << 4;  // 010000

    const LONGITUDE = 1 << 5; // 100000

    /**
     * @var float
     */
    public $decimal;

    /**
     * @var float
     */
    public $dms;

    /**
     * @var integer
     */
    public $direction;

    /**
     * @var integer
     */
    public $type;

    private function __construct()
    {
    }

    /**
     * @param number $decimal
     * @param integer $type
     * @return static
     * @throws Exception
     */
    public static function fromDecimal($decimal, $type)
    {
        if (!is_numeric($decimal) || abs($decimal) > 180) {
            throw new Exception('Incorrect value of the decimal.');
        } elseif (!($type & (self::LATITUDE | self::LONGITUDE))) {
            throw new Exception('Incorrect type.');
        }
        $coordinate = new static();
        $coordinate->decimal = $decimal;
        $coordinate->type = $type;

        $decimal = abs($decimal);

        $degrees = floor($decimal);
        $seconds = ($decimal - $degrees) * 3600;
        $minutes = floor($seconds / 60);
        $seconds -= $minutes * 60;

        $coordinate->dms = [$degrees, $minutes, $seconds];
        if ($type & self::LATITUDE) {
            $coordinate->direction = $coordinate->decimal < 0 ? self::SOUTH : self::NORTH;
        } else {
            $coordinate->direction = $coordinate->decimal < 0 ? self::WEST : self::EAST;
        }
        return $coordinate;
    }

    /**
     * @param integer $degrees
     * @param integer $minutes
     * @param number $seconds
     * @param integer $direction
     * @return static
     * @throws Exception
     */
    public static function fromDms($degrees, $minutes, $seconds, $direction)
    {
        if (!is_int($degrees) || $degrees < 0 || $degrees > 180) {
            throw new Exception('Incorrect value of the degrees.');
        } elseif (!is_int($minutes) || $minutes < 0 || $minutes > 59) {
            throw new Exception('Incorrect value of the minutes.');
        } elseif (!is_numeric($seconds) || $seconds < 0 || $seconds > 59) {
            throw new Exception('Incorrect value of the seconds.');
        } elseif (!($direction & (self::NORTH | self::SOUTH | self::WEST | self::EAST))) {
            throw new Exception('Incorrect direction.');
        }
        $coordinate = new static();
        $coordinate->decimal = $degrees + ($minutes / 60) + ($seconds / 3600);
        $coordinate->direction = $direction;

        if ($direction & (self::SOUTH | self::WEST)) {
            $coordinate->decimal *= -1;
        }

        $coordinate->type = ($direction & (self::SOUTH | self::NORTH)) ? self::LATITUDE : self::LONGITUDE;

        $coordinate->dms = [$degrees, $minutes, $seconds];
        return $coordinate;
    }
}
