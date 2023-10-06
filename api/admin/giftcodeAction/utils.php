<?php
require 'pdo.php';

class GiftcodeUtils extends GiftcodePDO {
  /* Get Giftcode  */
  public function getGiftcode ($id) {
    if(!is_numeric($id)) return res(400, 'Dữ liệu đầu vào sai');

    $giftcode = (new _PDO())->select(self::$PDO_GetGiftcode, array('id' => $id));

    if(empty($giftcode)) return res(400, 'Nhiệm vụ không tồn tại');
    return $giftcode;
  }

  /* Get Giftcode By Name */
  public function getGiftcodeByName ($name) {
    if(empty($name)) return res(400, 'Dữ liệu đầu vào sai');

    $giftcode = (new _PDO())->select(self::$PDO_GetGiftcodeByName, array('name' => $name));

    if(!empty($giftcode)) return res(400, 'Mã đã tồn tại');
    return $giftcode;
  }
}