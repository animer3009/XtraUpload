<?php

namespace Type;

class FileSize
{
    protected static $UNITS = array(
        'B'  => 1,
        'KB' => 1024,
        'MB' => 1048576,
        'GB' => 1073741824,
        'TB' => 1099511627776,
    );

    protected $amount;
    protected $unit;

    public function __construct($amount, $unit)
    {
        $this->setAmount($amount);
        $this->setUnit($unit);
    }

    protected function setAmount($amount)
    {
        if (!is_integer($amount)) {
            throw new \InvalidArgumentException("Amount must be expressed as an integer.");
        }

        $this->amount = $amount;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function formatAs($unit)
    {
        if (!in_array($unit, array_keys(self::$UNITS))) {
            throw new \InvalidArgumentException("Unit is not supported: {$unit} is not in (B,KB,MB,GB,TB)");
        }

        if($unit === $this->getUnit()) {
            return clone $this;
        }

        $amountAsNewFormat = $this->getAmount() * self::$UNITS[$this->getUnit()] / self::$UNITS[$unit];

        return new self($amountAsNewFormat, $unit);
    }

    protected function setUnit($unit)
    {
        if (!in_array($unit, array_keys(self::$UNITS))) {
            throw new \InvalidArgumentException("Unit is not supported: {$unit} is not in (B,KB,MB,GB,TB)");
        }

        $this->unit = $unit;
    }

    public function getUnit()
    {
        return $this->unit;
    }
}