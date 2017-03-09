<?php

namespace webtoucher\geometeo\libs;

abstract class Calculator
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @param integer $fields Bit mask of fields or NULL for all fields.
     * @param array $options
     */
    public function __construct($fields = null, array $options = [])
    {
        if (null === $fields) {
            $this->fields = array_fill_keys($this->getFieldRoster(), null);
        } else {
            foreach ($this->getFieldRoster() as $field) {
                if ($fields & $field) {
                    $this->fields[$field] = null;
                }
            }
        }
        $this->options = array_merge($this->options, $options);
    }

    /**
     * Calculates target values.
     *
     * @param GeoDataProvider $provider
     * @param string $date
     * @param array $inputValues
     * @return array
     */
    public function calculate(GeoDataProvider $provider, $date, array $inputValues = [])
    {
        $this->resetData();
        $fields = array_keys($this->fields);
        foreach ($fields as $field) {
            $this->calculateField($provider, $field, $date, $inputValues);
        }
        return $this->fields;
    }

    /**
     * Clear all fields.
     *
     * @return void
     */
    protected function resetData()
    {
        $this->fields = array_fill_keys(array_keys($this->fields), null);
    }

    /**
     * @param GeoDataProvider $provider
     * @param integer $field
     * @param string $date
     * @param array $inputValues
     * @return void
     */
    abstract protected function calculateField(GeoDataProvider $provider, $field, $date, array $inputValues);

    /**
     * Returns the list of the available for calculation parameters.
     *
     * @return integer[]
     */
    abstract protected function getFieldRoster();
}
