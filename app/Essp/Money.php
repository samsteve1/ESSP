<?php

namespace App\Essp;

use Money\Currency;
use \NumberFormatter;
use Money\Money as BaseMoney;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;

class Money
{
    protected $money;

    public function __construct($value)
    {
        $this->money = new BaseMoney($value, new Currency('USD'));
    }

    /**
     * Returns a formatted currency in USD, good for UI
     */
    public function formatted()
    {
        $formatter = new IntlMoneyFormatter(
            new  NumberFormatter('en_US', NumberFormatter::CURRENCY),
            new ISOCurrencies()
        );
        return $formatter->format($this->money);
    }

    /**
     * Returns the actual amount, used for computation
     */
    public function amount()
    {
        return $this->money->getAmount();
    }

    /**
     * Returns an instance of the Money class.
     */
    public function instance()
    {
        return $this->money;
    }
}
