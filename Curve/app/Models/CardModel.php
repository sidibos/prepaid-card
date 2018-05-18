<?php
namespace App\Models;

use App\Card;
use Illuminate\Database\Eloquent\Model;

class CardModel
{
    /**
     * @var Money
     */
    public $balance;
    /**
     * @var Money
     */
    public $blockedAmount;

    public function __construct(Money $balance, Money $blockedAmount) {
        $this->balance = $balance;
        $this->blockedAmount = $blockedAmount;
    }

    public function addMoneyOn(Card $card, Money $money)
    {
        $balance = new Money($card->balance);
        $balance->add($money);
        $card->balance = $balance->getAmount();

        return $card;
    }

    public function getAvailableBalance()
    {
        return $this->balance->getAmount() - $this->blockedAmount->getAmount();
    }

    public function hasSufficientFund(Money $money)
    {
        return ($this->getAvailableBalance() - $money->getAmount()) > 0;
    }
}