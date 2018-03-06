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
     * @param string $name
     * @param string $cmcticker
     */
    public function __construct($id,$name,$cmcticker,$imageurl)
    {
        $this->cmcticker= $cmcticker;
        $this->id = $id;
        $this->name = $name;
        $this->imageUrl = $imageurl;
    }
    public function GetId()
    {
        return $this->id;
    }
    public function GetTicker()
    {
        return $this->cmcticker;
    }
    public function GetName()
    {
        return $this->name;
    }
    public function GetImageUrl()
    {
        return $this->imageUrl;
    }
}