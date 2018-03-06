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
        $this->dblink = new mysqli("localhost",$dbconfig["user"],$dbconfig["pass"],$dbconfig["dbname"]);
    }
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

    public function AddHourPriceData( $coinId, $usdvalue)
    {
        $query = "INSERT INTO  `hourly` (`coinid`,`usdvalue`) VALUES ($coinId,$usdvalue)";
        $this->dblink->query($query);
    }

    public function AddDailyPriceData( $coinId,  $usdvalue,$day)
    {
        $query = "INSERT INTO  `daily` (`coinid`,`usdvalue`,`dateAdded`) VALUES ($coinId,$usdvalue,'$day')";
       $this->dblink->query($query);
    }
    private function GetPriceData($startTimestamp, $endTimestamp, $holdings,$interval)
    {
        $checkingDate = $startTimestamp;
        while($checkingDate <= $endTimestamp) {

            $usdValue = 0;
            foreach ($holdings as $holding) {
                if (date("Y-m-d",$holding->GetDate()) <= date("Y-m-d",$checkingDate)) //Was this holding added to the portfolio at the date we are checking?
                {

                    //get history from db
                        $datestring = date("Y-m-d",$checkingDate);

                    $holdingCoin = $holding->GetCoin()->GetId();

                    $query = "SELECT * FROM `".$interval."` WHERE DATE(`dateAdded`) = '$datestring' AND `coinid` = $holdingCoin"; // TODO: Run that query for all coins in holdings
                    $res = $this->dblink->query($query);
                    $row = mysqli_fetch_assoc($res);
                    $usdValue += $row["usdvalue"];
                    
                }
            }
            if ($usdValue > 0) {
                $holdingDataForChart[] = array(
                    "date" => $checkingDate,
                    "value" => $usdValue);
            }

            $checkingDate = $checkingDate + (60 * 60 * 24); //adding a full day to the timestamp
        }
        echo mysqli_error($this->dblink);
        return $holdingDataForChart;
    }

    public function GetDailyPriceData( $startTimeStamp,  $endTimestamp, $holdings)
    {
        return $this->GetPriceData($startTimeStamp,$endTimestamp,$holdings,"daily");
    }
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
    public function GetCoin($id)
    {
        $res = $this->dblink->query("SELECT * FROM coin WHERE id = $id");
        $coinarray = array();
        $row = mysqli_fetch_assoc($res);

           return  new Entities\Coin($row["id"],$row["name"],$row["coinmarketticker"],$row["image"]);
    }

    public function GetAmountsOfCertainCoin($coinid)
    {
       $res = $this->dblink->query("SELECT SUM(`amount`) FROM holding WHERE coinid = $coinid");
        $amount = mysqli_fetch_array($res)[0];
        return $amount;
    }
    public function UpdateDaily($coins)
    {
        foreach($coins as $coin)
        {
            $query = "SELECT AVG(`usdvalue`) FROM `hourly` WHERE DATE(`dateAdded`) = SUBDATE(CURDATE(),1) AND `coinid` = ".$coin->GetId();
            $res =  $this->dblink->query($query);
            $value = mysqli_fetch_array($res)[0];
            $yesterday = date('Y-m-d',strtotime("-1 days"));
            $this->AddDailyPriceData($coin->GetId(),$value,$yesterday);

        }


    }
    public function GetLatestValueOfCoin($coinid)
    {
        $res = $this->dblink->query("SELECT `usdvalue` FROM `hourly` WHERE `coinid` = $coinid ORDER BY `dateAdded` DESC LIMIT 1");
        $row = mysqli_fetch_assoc($res);
        return $row["usdvalue"];
    }
}