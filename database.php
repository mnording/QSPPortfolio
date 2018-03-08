<?php

/**
 * Created by PhpStorm.
 * User: matti
 * Date: 2018-03-01
 * Time: 14:24
 */
error_reporting(-1);
require 'interfaces/DataStorage.php';
require_once 'Entities/Coin.php';
require_once 'Entities/Holding.php';
require_once 'dbconfig.php';
class database implements \interfaces\DataStorage
{

    private $dblink;

    public function __construct($dbconfig)
    {
        $this->dblink = new mysqli($dbconfig["hostname"],$dbconfig["user"],$dbconfig["pass"],$dbconfig["dbname"]);
    }

    /***
     * @return array Array of holdings
     */
    public function GetHoldings()
    {
        $query ="SELECT * FROM  `holding` ";
        $res = $this->dblink->query($query);
        $result = array();
        while($row = mysqli_fetch_assoc($res))
        {
            $result[] = new \Entities\Holding($this->GetCoin($row["coinid"]),$row["dateAdded"],$row["amount"]);
        }
        return $result;
    }

    /***
     * @param Entities\Coin $coin The coin that with the new value
     * @param $usdvalue The new usd value
     */
    public function AddHourPriceData($coin, $usdvalue)
    {
        $coinid = $coin->GetId();
        $query = "INSERT INTO  `hourly` (`coinid`,`usdvalue`) VALUES ($coinid,$usdvalue)";
        $this->dblink->query($query);
    }

    /***
     * @param $coin
     * @param $usdvalue
     * @param $day
     */
    public function AddDailyPriceData( $coin,  $usdvalue,$day)
    {
        $coinid = $coin->GetId();
        $query = "INSERT INTO  `daily` (`coinid`,`usdvalue`,`dateAdded`) VALUES ($coinid,$usdvalue,'$day')";
       $this->dblink->query($query);
    }

    /***
     * @param $startTimestamp
     * @param $endTimestamp
     * @param $holdings
     * @param $interval
     * @return array
     */
    private function GetPriceData($startTimestamp, $endTimestamp, $interval)
    {
            $query = "SELECT SUM(`usdvalue`),`dateAdded` FROM `" . $interval . "` WHERE `dateAdded` > FROM_UNIXTIME($startTimestamp) AND `dateAdded` < FROM_UNIXTIME($endTimestamp) GROUP BY `dateAdded`  ORDER BY `dateAdded`";
            echo $query;
            $res = $this->dblink->query($query);
            while($row = mysqli_fetch_array($res))
            {
                $holdingDataForChart[] = array(
                    "date" =>  $row[1],
                    "value" =>  $row[0]);
            }

        echo mysqli_error($this->dblink);
        return $holdingDataForChart;
    }

    /***
     * @param $startTimeStamp
     * @param $endTimestamp
     * @param $holdings
     * @return array
     */
    public function GetDailyPriceData( $startTimeStamp,  $endTimestamp)
    {
        return $this->GetPriceData($startTimeStamp,$endTimestamp,"daily");
    }
    public function GetDailyPriceDataByCoin($starttime,$endtime)
    {
            $coins = $this->GetCoins();
        $completeArray = array();
        foreach($coins as $coin)
        {
            $coinid = $coin->GetId();
            $query = "SELECT * FROM `daily` WHERE `dateAdded` > FROM_UNIXTIME($starttime) AND `dateAdded` < FROM_UNIXTIME($endtime) AND `coinid` = $coinid  ORDER BY `dateAdded`"; // TODO: Run that query for all coins in holdings
            $res = $this->dblink->query($query);
            $coinarray = array();
            while($row = mysqli_fetch_assoc($res))
            {
                $coinarray[] = intval($row["usdvalue"]);

            }
            $dataarray = array(
                "name" => $coin->GetName(),
                "data" => $coinarray
            );
            $completeArray[] = $dataarray;
        }
        return $completeArray;

    }
    /***
     * @return array Return all coins in the DB
     */
    public function GetCoins()
    {
        $res = $this->dblink->query("SELECT * FROM coin");
        $coinarray = array();
        while($row = mysqli_fetch_assoc($res))
        {
            $coinarray[] = new Entities\Coin($row["id"],$row["name"],$row["coinmarketticker"],$row["image"]);
        }
        return $coinarray;
    }

    /**
     * @param $id Id of the coin
     * @return \Entities\Coin the coin requested
     */
    public function GetCoin($id)
    {
        $res = $this->dblink->query("SELECT * FROM coin WHERE id = $id");
        $coinarray = array();
        $row = mysqli_fetch_assoc($res);

           return  new Entities\Coin($row["id"],$row["name"],$row["coinmarketticker"],$row["image"]);
    }

    /***
     * @param $coinid
     * @return int Amount held of certain coin
     */
    public function GetAmountsOfCertainCoin($coinid) : int
    {
       $res = $this->dblink->query("SELECT SUM(`amount`) FROM holding WHERE coinid = $coinid");
        $amount = mysqli_fetch_array($res)[0];
        return intval($amount);
    }

    /***
     * @param $coins An array of Coins that should be updated.
     */
    public function UpdateDaily($coins)
    {
        foreach($coins as $coin)
        {
            $query = "SELECT AVG(`usdvalue`) FROM `hourly` WHERE DATE(`dateAdded`) = SUBDATE(CURDATE(),1) AND `coinid` = ".$coin->GetId();
            $res =  $this->dblink->query($query);
            $value = mysqli_fetch_array($res)[0];
            $yesterday = date('Y-m-d',strtotime("-1 days"));
            $this->AddDailyPriceData($coin,$value,$yesterday);

        }


    }
    public function GetLatestValueOfCoin($coinid)
    {
        $res = $this->dblink->query("SELECT `usdvalue` FROM `hourly` WHERE `coinid` = $coinid ORDER BY `dateAdded` DESC LIMIT 1");
        $row = mysqli_fetch_assoc($res);
        return $row["usdvalue"];
    }
}