<?php

namespace webtoucher\geometeo\libs;

use webtoucher\geometeo\libs\helpers\AngleHelper;

class SunCalculator extends Calculator
{
    const AZIMUTH = 1 << 0;  // 0001

    const ALTITUDE = 1 << 1; // 0010

    /**
     * @inheritdoc
     */
    protected function getFieldRoster()
    {
        return [
            self::AZIMUTH,
            self::ALTITUDE,
        ];
    }

    /**
     * @inheritdoc
     * @throws \webtoucher\geometeo\libs\Exception
     */
    protected function calculateField(GeoDataProvider $provider, $field, $date, array $inputValues)
    {
        switch ($field) {
            case self::AZIMUTH:
            case self::ALTITUDE:
                if (null === $this->fields[$field]) {
                    $this->calculatePosition($date, $provider->getLatitude(), $provider->getLongitude());
                }
                break;
            default:
                throw new Exception('Unknown field is called.');
        }
    }

    /**
     * @param \DateTime $dateTime
     * @param $latitude
     * @param $longitude
     */
    private function calculatePosition(\DateTime $dateTime, $latitude, $longitude)
    {
        $dateTime->setTimezone(new \DateTimeZone('UTC'));
        $j2000Days = $this->getJ2000Day($dateTime);
        $hour = (integer) $dateTime->format('G');
        $minute = (integer) $dateTime->format('i');
        $utcTime = $hour + $minute / 60;

        $perihelionLongitude = 282.9404 + 4.70935 * 10 ** -5 * $j2000Days;
        $eccentricity = 0.016709 - 1.151 * 10 ** -9 * $j2000Days;
        $meanAnomaly = AngleHelper::to360Range(356.0470 + 0.9856002585 * $j2000Days);
        $eclipticObliquity = 23.4393 - 3.563 * 10 ** -7 * $j2000Days;
        $meanLongitude = AngleHelper::to360Range($perihelionLongitude + $meanAnomaly);
        $eccentricAnomaly = $meanAnomaly
            + AngleHelper::toDegrees($eccentricity * AngleHelper::sin($meanAnomaly) * (1 + $eccentricity * AngleHelper::cos($meanAnomaly)));

        $x = AngleHelper::cos($eccentricAnomaly) - $eccentricity;
        $y = AngleHelper::sin($eccentricAnomaly) * sqrt(1 - $eccentricity ** 2);

        $distance = sqrt($x ** 2 + $y ** 2);
        $anomaly = AngleHelper::atan2($y, $x);

        $sunLongitude = AngleHelper::to360Range($anomaly + $perihelionLongitude);
        $x = $distance * AngleHelper::cos($sunLongitude);
        $y = $distance * AngleHelper::sin($sunLongitude);

        $xEquatorial = $x;
        $yEquatorial = $y * AngleHelper::cos($eclipticObliquity);
        $zEquatorial = $y * AngleHelper::sin($eclipticObliquity);

        $rightAscension = AngleHelper::atan2($yEquatorial, $xEquatorial);
        $declination = AngleHelper::asin($zEquatorial / $distance);

        $siderealTime = $meanLongitude / 15 + $longitude / 15 + $utcTime + 12;
        $siderealTime -= 24 * floor($siderealTime / 24);

        $hourAngle = AngleHelper::to360Range(15 * ($siderealTime - $rightAscension / 15));

        $x = AngleHelper::cos($hourAngle) * AngleHelper::cos($declination);
        $y = AngleHelper::sin($hourAngle) * AngleHelper::cos($declination);
        $z = AngleHelper::sin($declination);

        $xHor = $x * AngleHelper::sin($latitude) - $z * AngleHelper::cos($latitude);
        $zHor = $x * AngleHelper::cos($latitude) + $z * AngleHelper::sin($latitude);

        $this->fields[self::AZIMUTH] = AngleHelper::to360Range(AngleHelper::atan2($y, $xHor) + 180);
        $this->fields[self::ALTITUDE] = AngleHelper::asin($zHor);
    }

    /**
     * Returns the number of days from J2000.0.
     *
     * @param \DateTime $dateTime
     * @return number
     */
    private function getJ2000Day(\DateTime $dateTime)
    {
        $day = (integer) $dateTime->format('j');
        $month = (integer) $dateTime->format('n');
        $year = (integer) $dateTime->format('Y');
        return floor(367 * $year - (7 * ($year + (($month + 9) / 12))) / 4 + (275 * $month) / 9 + $day - 730530);
    }
}
