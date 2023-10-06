<?php
require 'pdo.php';

class WheelUtils extends WheelPDO {
  /* Get Wheel Gift By ID */
  public function getWheelGift ($id) {
    if(!is_numeric($id)) return res(400, 'Không tìm thấy ID phần thưởng');

    $gift = (new _PDO())->select(self::$PDO_GetWheelGift, array('id' => $id));

    if(empty($gift)) return res(400, 'Phần thưởng không tồn tại');
    return $gift;
  }
}