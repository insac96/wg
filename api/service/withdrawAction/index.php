<?php
require 'utils.php';

class Withdraw extends WithdrawUtils {
  /* Get All Withdraw Of User */
  public function getAllWithdraw ($user) {
    $account = $user['account'];
    $count = (new _PDO())->select("SELECT count(id) AS total FROM ny_withdraw WHERE account=:account", array(
      'account' => $account
    ));
    $count = $count['total'];

    return getTableList(null, "SELECT * FROM ny_withdraw WHERE account='$account'", $count);
  }

  /* Withdraw Money */
  public function withdrawMoney ($user) {
    // Check Data
    if(empty($_POST['diamond']))
      res(400, 'Dữ liệu đầu vào sai');

    // Check Diamond
    if((int)$_POST['diamond'] <= 0)
      res(400, 'Vui lòng nhập số lượng kim cương');
    if((int)$user['diamond'] < (int)$_POST['diamond'])
      res(400, 'Số dư kim cương không đủ');

    // Set And Chech Money
    $money = (int)$user['vip']['diamond_to_money'] * (int)$_POST['diamond'];
    if($money < 50000)
      res(400, 'Số tiền tối thiểu được rút phải đạt 50.000');

    // Make Token
    $token = $this->makeToken();

    // Create Withdraw
    (new _PDO())->create('ny_withdraw', array(
      'account' => (string)$user['account'],
      'diamond' => (int)$_POST['diamond'],
      'money' => (int)$money,
      'code' => '',
      'token' => (string)$token,
      'create_time' => time()
    ));

    // Get New and Update Code
    $withdraw = $this->getWithdrawByToken($token);
    $withdraw_id = $withdraw['id'];
    $code = $this->makeCode($withdraw_id);

    (new _PDO())->update('ny_withdraw', array('code' => (string)$code), array(
      'id' => $withdraw_id
    ));

    // Update User
    (new User())->updateUser($user['account'], array(
      'diamond' => array('-', (int)$_POST['diamond'])
    ));
  }
}