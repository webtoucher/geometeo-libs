<?php

namespace webtoucher\geometeo\libs\helpers;

class AngleHelper
{
    /**
     * Returns angle converted to 0-360 range.
     *
     * @param number $value
     * @return float
     */
    public static function to360Range($value)
    {
        if ($value > 360) {
            return $value * 1.0 - floor($value / 360) * 360;
        } elseif ($value < 0) {
            return $value * 1.0 + (floor(-$value / 360) + 1) * 360;
        }
        return $value;
    }

    /**
     * Returns the sine of arg.
     *
     * @param number $arg An angle in degrees.
     * @return float
     */
    public static function sin($arg)
    {
        return sin(self::toRadians($arg));
    }

    /**
     * Returns the cosine of arg.
     *
     * @param number $arg An angle in degrees.
     * @return float
     */
    public static function cos($arg)
    {
        return cos(self::toRadians($arg));
    }

    /**
     * Returns the arc sine of arg in degrees.
     *
     * @param number $arg
     * @return float
     */
    public static function asin($arg)
    {
        return self::toDegrees(asin($arg));
    }

    /**
     * Returns the arc tangent of y/x in degrees.
     *
     * @param number $y Dividend parameter.
     * @param number $x Divisor parameter.
     * @return float
     */
    public static function atan2($y, $x)
    {
        return self::toDegrees(atan2($y, $x));
    }

    /**
     * Returns angle converted from degrees to radians.
     *
     * @param number $degrees
     * @return float
     */
    public static function toRadians($degrees)
    {
        return $degrees * M_PI / 180;
    }

    /**
     * Returns angle converted from radians to degrees.
     *
     * @param number $radians
     * @return float
     */
    public static function toDegrees($radians)
    {
        return $radians * 180 / M_PI;
    }
}
