<?php
require 'pdo.php';

class ShopUtils extends ShopPDO {
  /* Get Recharge By ID */
  public function getRecharge ($id, $boolean = false) {
    if(!is_numeric($id)) return res(400, 'Không tìm thấy ID gói');

    $recharge = (new _PDO())->select(self::$PDO_GetRecharge, array('id' => $id));

    if(!$boolean){
      if(empty($recharge)) return res(400, 'Gói không tồn tại');
      return $recharge;
    }
    else {
      if(empty($recharge)) return false;
      return true;
    }
  }

  /* Get Item By ID */
  public function getItem ($id, $boolean = false) {
    if(!is_numeric($id)) return res(400, 'Không tìm thấy ID vật phẩm');

    $item = (new _PDO())->select(self::$PDO_GetItem, array('id' => $id));

    if(!$boolean){
      if(empty($item)) return res(400, 'Vật phẩm không tồn tại');
      return $item;
    }
    else {
      if(empty($item)) return false;
      return true;
    }
  }

  /* Get Currency Buy ID */
  public function getCurrency ($id) {
    if(!is_numeric($id)) return res(400, 'Không tìm thấy ID gói tiền tệ');

    $currency = (new _PDO())->select(self::$PDO_GetCurrency, array('id' => $id));
    if(empty($currency)) return res(400, 'Gói tiền tệ không tồn tại');
    return $currency;
  }

  /* Get Effect Buy ID */
  public function getEffect ($id) {
    if(!is_numeric($id)) return res(400, 'Không tìm thấy ID hiệu ứng');

    $effect = (new _PDO())->select(self::$PDO_GetEffect, array('id' => $id));
    if(empty($effect)) return res(400, 'Hiệu ứng không tồn tại');
    return $effect;
  }
}