<?php
require 'pdo.php';

class LogUtils extends LogPDO {
  /* Search Admin */
  public function searchLogAdmin () {
    $sqlCount = "SELECT 
      count(id) AS total 
      FROM ny_log_admin 
      WHERE account LIKE :query 
      OR type LIKE :query
    ";

    $sqlSearch = "SELECT * 
      FROM ny_log_admin
      WHERE account LIKE :query
      OR type LIKE :query
    ";

    return getTableSearch($sqlCount, $sqlSearch);
  }

  /* Search Shop */
  public function searchLogShop () {
    $sqlCount = "SELECT 
      count(id) AS total 
      FROM ny_log_shop 
      WHERE account LIKE :query 
      OR server_id LIKE :query
      OR shop_type LIKE :query
    ";

    $sqlSearch = "SELECT *
      FROM ny_log_shop 
      WHERE account LIKE :query
      OR server_id LIKE :query
      OR shop_type LIKE :query
    ";

    return getTableSearch($sqlCount, $sqlSearch);
  }

  /* Search Event */
  public function searchLogEvent () {
    $sqlCount = "SELECT 
      count(id) AS total 
      FROM ny_log_event 
      WHERE account LIKE :query 
      OR server_id LIKE :query
    ";

    $sqlSearch = "SELECT *
      FROM ny_log_event 
      WHERE account LIKE :query
      OR server_id LIKE :query
    ";

    return getTableSearch($sqlCount, $sqlSearch);
  }

  /* Search Mission */
  public function searchLogMission () {
    $sqlCount = "SELECT 
      count(id) AS total 
      FROM ny_log_mission
      WHERE account LIKE :query 
      OR server_id LIKE :query
    ";

    $sqlSearch = "SELECT *
      FROM ny_log_mission 
      WHERE account LIKE :query 
      OR server_id LIKE :query
    ";

    return getTableSearch($sqlCount, $sqlSearch);
  }

  /* Search Wheel */
  public function searchLogWheel () {
    $sqlCount = "SELECT 
      count(id) AS total 
      FROM ny_log_wheel
      WHERE account LIKE :query 
      OR server_id LIKE :query
    ";

    $sqlSearch = "SELECT *
      FROM ny_log_wheel 
      WHERE account LIKE :query 
      OR server_id LIKE :query
    ";

    return getTableSearch($sqlCount, $sqlSearch);
  }

  /* Search Dice */
  public function searchLogDice () {
    $sqlCount = "SELECT 
      count(id) AS total 
      FROM ny_log_dice
      WHERE account LIKE :query
    ";

    $sqlSearch = "SELECT *
      FROM ny_log_dice 
      WHERE account LIKE :query
    ";

    return getTableSearch($sqlCount, $sqlSearch);
  }

  /* Search Giftcode */
  public function searchLogGiftcode () {
    $sqlCount = "SELECT 
      count(id) AS total 
      FROM ny_log_giftcode
      WHERE account LIKE :query 
      OR server_id LIKE :query
    ";

    $sqlSearch = "SELECT *
      FROM ny_log_giftcode 
      WHERE account LIKE :query 
      OR server_id LIKE :query
    ";

    return getTableSearch($sqlCount, $sqlSearch);
  }
}