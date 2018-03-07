<?php

/**
 * Created by PhpStorm.
 * User: matti
 * Date: 2018-03-05
 * Time: 09:08
 */
namespace Entities;
class Coin
{
    private $id;
    private $name;
    private $cmcticker;
    private $imageUrl;

    /***
     * @param int $id
     * @param string $name Coin Symbol
     * @param string $cmcticker Ticker used by CoinmarketCap
     */
    public function __construct($id,$name,$cmcticker,$imageurl)
    {
        $this->cmcticker= $cmcticker;
        $this->id = $id;
        $this->name = $name;
        $this->imageUrl = $imageurl;
    }

    /**
     * @return int Id of the Coin
     */
    public function GetId()
    {
        return intval($this->id);
    }

    /**
     * @return string Ticker used by CoinmarketCap
     */
    public function GetTicker()
    {
        return $this->cmcticker;
    }

    /***
     * @return string The Symbol of the token
     */
    public function GetName()
    {
        return $this->name;
    }

    /***
     * @return string URL of logo
     */
    public function GetImageUrl()
    {
        return $this->imageUrl;
    }
}