<?php
require 'pdo.php';

class WithdrawUtils extends WithdrawPDO {
  /* Make Code */
  public function makeCode ($withdraw_id) {
    $config = (new Config())->getConfigAll();
    $prefix = !empty($config['prefix_withdraw']) ? $config['prefix_withdraw'] : 'W-';
    return $prefix.''.str_pad($withdraw_id, 4, '0', STR_PAD_LEFT);
  }

  /* Make Token */
  public function makeToken () {
    $time = strval(time());
    $rand = rand(0, 999);
    return md5($time.$rand);
  }
  
  /* Get Withdraw By Token */
  public function getWithdrawByToken ($token) {
    if(empty($token)) return res(400, 'Dữ liệu đầu vào sai');

    $withdraw = (new _PDO())->select(self::$PDO_GetWithdrawByToken, array('token' => $token));
    if(empty($withdraw)) return res(400, 'Giao dịch không tồn tại');
    return $withdraw;
  }
}