<?php
require 'pdo.php';

class GateUtils extends GatePDO {
  /* Get Gate By ID */
  public function getGate ($id) {
    if(!is_numeric($id)) return res(400, 'Dữ liệu đầu vào sai');

    $gate = (new _PDO())->select(self::$PDO_GetGate, array('id' => $id));

    if(empty($gate)) return res(400, 'Kênh thanh toán không tồn tại');
    return $gate;
  }
}