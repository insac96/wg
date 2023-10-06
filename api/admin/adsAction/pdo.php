<?php
class AdsPDO {
  static $PDO_GetAllAds = "SELECT * FROM ny_ads";
  static $PDO_GetAds = "SELECT * FROM ny_ads WHERE id=:id";
}