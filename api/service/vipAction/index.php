<?php
require 'utils.php';

class Vip extends VipUtils {
  /* Get All Vip */
  public function getAllVip () {
    $list = (new _PDO())->select(self::$PDO_GetAllVip, [], true);
    return $list;
  }
}