<?php
require 'utils.php';

class Ads extends AdsUtils {
  /* Get All Ads */
  public function getAllAds () {
    return (new _PDO())->select(self::$PDO_GetAllAds, [], true);
  }
}