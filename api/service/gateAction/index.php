<?php
require 'utils.php';

class Gate extends GateUtils {
  /* Gett All Gate */
  public function getAllGate () {
    $list = (new _PDO())->select(self::$PDO_GetAllGate, [], true);
    return $list;
  }
}