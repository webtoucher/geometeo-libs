<?php

namespace webtoucher\geometeo\libs;

class WindCalculator extends Calculator
{
    const POWER = 1 << 0; // 0000

    /**
     * @inheritdoc
     */
    protected function getFieldRoster()
    {
        return [
            self::POWER,
        ];
    }

    /**
     * @inheritdoc
     * @throws \webtoucher\geometeo\libs\Exception
     */
    protected function calculateField(GeoDataProvider $provider, $field, $date, array $inputValues)
    {
        switch ($field) {
            case self::POWER:
                return $this->getPower();
            default:
                throw new Exception('Unknown field is called.');
        }
    }

    /**
     * @return number
     */
    private function getPower()
    {
        return 0;
    }
}
