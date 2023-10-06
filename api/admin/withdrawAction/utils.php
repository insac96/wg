<?php
require 'pdo.php';

class WithdrawUtils extends WithdrawPDO {
  /* Get Withdraw By ID */
  public function getWithdraw ($code) {
    if(empty($code)) return res(400, 'Dữ liệu đầu vào sai');

    $withdraw = (new _PDO())->select(self::$PDO_GetWithdraw, array('code' => $code));

    if(empty($withdraw)) return res(400, 'Giao dịch không tồn tại');
    return $withdraw;
  }
}