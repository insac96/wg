<?php
require 'pdo.php';

class PayUtils extends PayPDO {
  /* Get Pay By Code */
  public function getPay ($code) {
    if(empty($code)) return res(400, 'Dữ liệu đầu vào sai');

    $pay = (new _PDO())->select(self::$PDO_GetPay, array('code' => $code));

    if(empty($pay)) return res(400, 'Giao dịch không tồn tại');
    return $pay;
  }
}