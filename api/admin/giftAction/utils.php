<?php
require 'pdo.php';

class GiftUtils extends GiftPDO {
  /* Get Gift  */
  public function getGift ($id) {
    if(!is_numeric($id)) return res(400, 'Dữ liệu đầu vào sai');

    $gift = (new _PDO())->select(self::$PDO_GetGift, array('id' => $id));

    if(empty($gift)) return res(400, 'Bộ quà tặng không tồn tại');
    return $gift;
  }
}