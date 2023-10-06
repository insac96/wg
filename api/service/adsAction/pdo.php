<?php
class AdsPDO {
  static $PDO_GetAllAds = "SELECT * FROM ny_ads WHERE display=1";
  static $PDO_GetAds = "SELECT * FROM ny_ads WHERE id=:id AND display=1";
}