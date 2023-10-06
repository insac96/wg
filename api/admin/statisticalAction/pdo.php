<?php
class StatisticalPDO {
  static $PDO_GetRevenueAll = "SELECT
    SUM(money) AS pay
    FROM ny_pay
    WHERE status = 1
  ";

  static $PDO_GetRevenueDay = "SELECT
    SUM(money) AS pay
    FROM ny_pay
    WHERE status = 1
    AND DATE_FORMAT(FROM_UNIXTIME(verify_time), '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d')
  ";

  static $PDO_GetRevenuePrevDay = "SELECT
    SUM(money) AS pay
    FROM ny_pay
    WHERE status = 1
    AND DATE_FORMAT(FROM_UNIXTIME(verify_time), '%Y-%m-%d') = DATE_FORMAT(NOW() - INTERVAL 1 DAY, '%Y-%m-%d')
  ";

  static $PDO_GetRevenueMonth = "SELECT
    SUM(money) AS pay
    FROM ny_pay
    WHERE status = 1
    AND DATE_FORMAT(FROM_UNIXTIME(verify_time), '%Y-%m-%d') >= DATE_FORMAT(NOW(), '%Y-%m-01')
  ";

  static $PDO_GetRevenuePrevMonth = "SELECT
    SUM(money) AS pay
    FROM ny_pay
    WHERE status = 1
    AND DATE_FORMAT(FROM_UNIXTIME(verify_time), '%Y-%m-%d') >= DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%Y-%m-01')
    AND DATE_FORMAT(FROM_UNIXTIME(verify_time), '%Y-%m-%d') < DATE_FORMAT(NOW(), '%Y-%m-01')
  ";
}