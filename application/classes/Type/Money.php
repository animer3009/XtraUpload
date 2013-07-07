<?php

namespace Type;

class Money
{
    protected $amount;
    protected $currency;

    public function __construct($amount, $currency)
    {
        $this->setAmount($amount);
        $this->setCurrency($currency);
    }

    /**
     * Set an amount.
     *
     * @param float $amount
     */
    protected function setAmount($amount)
    {
        // TODO: Implement to store in "pennies".
        $this->amount = $amount;
    }

    /**
     * Retrieve the amount.
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Sets the currency.
     *
     * @param $currency
     * @throws \InvalidArgumentException
     */
    protected function setCurrency($currency)
    {
        if(trim($currency) === false) {
            throw new \InvalidArgumentException("Argument one must have a string value.");
        }

        $this->currency = (string) $currency;
    }

    /**
     * Retrieve the currency.
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Add two amounts together.
     *
     * @param Money $money
     * @return Money
     * @throws \InvalidArgumentException
     */
    public function add(Money $money)
    {
        if ($this->getCurrency() !== $money->getCurrency()) {
            throw new \InvalidArgumentException("Argument one must be of same currency");
        }

        $addedAmount = $this->getAmount() + $money->getAmount();

        return new Money($addedAmount, $this->getCurrency());
    }

    /**
     * Subtract the argument amount from the main amount.
     *
     * @param Money $money
     * @return Money
     * @throws \InvalidArgumentException
     */
    public function subtract(Money $money)
    {
        if ($this->getCurrency() !== $money->getCurrency()) {
            throw new \InvalidArgumentException("Argument one must be of same currency");
        }

        $subtractedAmount = $this->getAmount() - $money->getAmount();

        return new Money($subtractedAmount, $this->getCurrency());
    }

    public function multiply(Money $money)
    {
        // TODO: implement stub.
    }

    public function allocate()
    {
        // TODO: implement stub.
    }

    /**
     * Compare if the amount is greater than the given amount.
     *
     * @param Money $money
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function greaterThan(Money $money)
    {
        if ($this->getCurrency() !== $money->getCurrency()) {
            throw new \InvalidArgumentException("Argument one must be of same currency");
        }

        return $this->getAmount() > $money->getAmount();
    }

    /**
     * Compare if the amount is less than the given amount.
     *
     * @param Money $money
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function lessThan(Money $money)
    {
        if ($this->getCurrency() !== $money->getCurrency()) {
            throw new \InvalidArgumentException("Argument one must be of same currency");
        }

        return $this->getAmount() < $money->getAmount();
    }

    /**
     * Compare if the amount is greater than or equal to the given amount.
     *
     * @param Money $money
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function greaterThanOrEqualTo(Money $money)
    {
        if ($this->getCurrency() !== $money->getCurrency()) {
            throw new \InvalidArgumentException("Argument one must be of same currency");
        }

        return $this->getAmount() >= $money->getAmount();
    }

    /**
     * Compare if the amount is less than or equal to the given amount.
     *
     * @param Money $money
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function lessThanOrEqualTo(Money $money)
    {
        if ($this->getCurrency() !== $money->getCurrency()) {
            throw new \InvalidArgumentException("Argument one must be of same currency");
        }

        return $this->getAmount() <= $money->getAmount();
    }

    /**
     * Compare if the amount is equal to the given amount.
     *
     * @param Money $money
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function equalTo(Money $money)
    {
        if ($this->getCurrency() !== $money->getCurrency()) {
            throw new \InvalidArgumentException("Argument one must be of same currency");
        }

        return $this->getAmount() === $money->getAmount();
    }
}