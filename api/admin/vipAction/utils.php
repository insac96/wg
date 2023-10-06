<?php
require 'pdo.php';

class VipUtils extends VipPDO {
  /* Get Vip */
  public function getVip ($number, $boolean = false) {
    $vip = (new _PDO())->select(self::$PDO_GetVip, array('number' => (int)$number));

    if(!$boolean){
      if(empty($vip)) return res(400, 'Không thể lấy thông tin đặc quyền VIP');
      return $vip;
    }
    
    if($boolean){
      if(empty($vip)) null;
      return $vip;
    }
  }
}