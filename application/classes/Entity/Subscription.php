<?php

namespace Entity;

use Entity;
use Type\Money;

class Subscription extends Entity
{
    const REPEAT_NEVER = 'repeat_never';
    const REPEAT_MONTHLY = 'repeat_monthly';
    const REPEAT_YEARLY = 'repeat_yearly';

    protected $price;
    protected $billingInterval;

    public function __construct($price, $billingInterval = self::REPEAT_NEVER, $id = null)
    {
        $this->setPrice($price);
        $this->setBillingInterval( $billingInterval );

        $this->setId($id);
    }

    public function setPrice(Money $price)
    {
        $this->price = $price;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setBillingInterval($interval)
    {
        if(!in_array($interval, array(self::REPEAT_NEVER, self::REPEAT_MONTHLY, self::REPEAT_YEARLY))) {
            throw new \InvalidArgumentException("Argument one must be an accepted interval");
        }

        $this->billingInterval = $interval;
    }

    public function isRepeatedBilling()
    {
        return $this->billingInterval;
    }
}