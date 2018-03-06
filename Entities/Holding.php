<?php

/**
 * Created by PhpStorm.
 * User: matti
 * Date: 2018-03-05
 * Time: 09:08
 */
namespace Entities;
class Holding
{
    /***
     * @var Coin $coin
     */
        private $coin;
        private $dateAdded;
        private $amountofCoins;
        private $description;

    /***
     * @param Coin $coin
     * @param int $dateAdded
     * @param int $amount
     */
    public function __construct($coin,$dateAdded,$amount)
    {
        $this->coin = $coin;
        $this->dateAdded = $dateAdded;
        $this->amountofCoins = $amount;
    }

    /***
     * @return Coin The coin being held
     */
    public function GetCoin()
    {
        return $this->coin;
    }

    /***
     * @return int Timespamp when the holding was added to the portfolio.
     */
    public function GetDate()
    {
        return $this->dateAdded;
    }

    /***
     * @return int Number of coins held.
     */
    public function GetAmountOfCoins()
    {
       return $this->amountofCoins;
    }

}