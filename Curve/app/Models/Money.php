<?php
namespace App\Models;

class Money
{
    /**
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $currency;

    /**
     * @param $amount
     * @param string $currency
     */
    public function __construct($amount, $currency = 'GBP')
    {
        $this->amount   = number_format($amount, 2, '.', '');
        $this->currency = $currency;
    }

    /**
     * returns money amount
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * returns Money currency
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * subtract Money from current Money
     * @param Money $moneyToDeduct
     * @throws \Exception
     */
    public function deduct(Money $moneyToDeduct)
    {
        if($this->hasEnough($moneyToDeduct)) {
            $this->amount = number_format($this->amount - $moneyToDeduct->getAmount(), 2, '.', '');
        }
    }

    public function add(Money $money)
    {
        $this->amount += $money->getAmount();
    }

    public function hasEnough(Money $money)
    {
        return $this->amount >= $money->getAmount();
    }

}