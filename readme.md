![alt text](https://caring.quantstamp.com/assets/quantstamp-logo-blue-abe1f18b6db596d0b2a44cc9a89c39214a6bd3915c0ab77e23adaff70266a59e.svg "Quantstamp PoC")

**Quantstamp Proof of Care Portfolio Tracker**

 [![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
 
This tool allows you to track the value of the Proof of Care program offered by [Quantstamp](https://quantstamp.com), the #1 security auditing company!



This tool is relying heavily on data from [CoinMarketCaps public API](https://coinmarketcap.com/api/). Big thanks to them for making this tool possible.


**Installation**


* Import the `quantstamp_portfolio.sql` file into a MYSQL database of your choice.
* Replace the sample connection data with real credentials inside of `dbconfig-sample.php`
* Rename `dbconfig-sample.php` to `dbconfig.php`


**Cron Jobs**

This tool fetches data from CoinmarketCap and builds its price structure from it.
The [live site](https://quantstampnews.com/portfolio/) fetches data everyhour and compiles that into daily data every day.
You are free to change the rate of data collection however please follow Coinmarketcaps recommendation of 10 minutes delay at least.

