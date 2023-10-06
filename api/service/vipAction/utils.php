<?php
require 'pdo.php';

class VipUtils extends VipPDO {
  /* Get Vip */
  public function getVip ($number) {
    $vip = (new _PDO())->select(self::$PDO_GetVip, array('number' => (int)$number));
    if(empty($vip)) return res(400, 'Không thể lấy thông tin đặc quyền VIP');
    return $vip;
  }

  /* Get Vip Next */
  public function getVipNew ($need_exp) {
    $vip = (new _PDO())->select(self::$PDO_GetVipNew, array('need_exp' => (int)$need_exp));
    return $vip;
  }
}