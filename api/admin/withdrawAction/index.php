<?php
require 'utils.php';

class Withdraw extends WithdrawUtils {
  /* Get All Withdraw Of User */
  public function getAllWithdraw () {
    return getTableList('ny_withdraw', self::$PDO_GetAllWithdraw);
  }

  /* Search Withdraw */
  public function searchWithdraw () {
    $sqlCount = "SELECT 
      count(id) AS total 
      FROM ny_withdraw 
      WHERE code LIKE :query
      OR account LIKE :query
      OR verifier LIKE :query
    ";

    $sqlSearch = "SELECT
      withdraw.*, auth.bank_name, auth.bank_person, auth.bank_stk
      FROM ny_withdraw withdraw
      LEFT JOIN ny_auth auth ON withdraw.account = auth.account
      WHERE withdraw.code LIKE :query
      OR withdraw.account LIKE :query
      OR withdraw.verifier LIKE :query
    ";

    return getTableSearch($sqlCount, $sqlSearch);
  }
  
  /* Verify Withdraw */
  public function verifyWithdraw ($admin) {
    if(empty($_POST['code']) || !is_numeric($_POST['status']))
      res(400, 'Dữ liệu đầu vào không đủ');

    // Get Withdraw
    $withdraw = $this->getWithdraw($_POST['code']);
    if((int)$withdraw['status'] > 0)
      res(400, 'Không thể thao tác trên giao dịch này');
    
    // Get User
    $user = (new User())->getUser($withdraw['account']);

    // Update Status
    $status = (int)$_POST['status'];
    (new _PDO())->update('ny_withdraw',
      array(
        'status' => (int)$status,
        'verify_time' => (int)time(),
        'verifier' => (string)$admin,
      ),
      array('code' => $withdraw['code'])
    );

    if($status == 1){
      (new _PDO())->create('ny_notify', array(
        'account' => (string)$user['account'],
        'type' => 'withdraw',
        'content' => 'Bạn được duyệt thành công giao dịch rút tiền ['.$withdraw['code'].'], nhận về ['.$withdraw['money'].' VNĐ]',
        'create_time' => time()
      ));

      logAdmin('Chấp nhận giao dịch rút tiền ['.$withdraw['code'].']');
    }

    else {
      (new User())->updateUser($user['account'], array(
        'diamond' => array('+', (int)$withdraw['diamond']),
      ));

      (new _PDO())->create('ny_notify', array(
        'account' => (string)$user['account'],
        'type' => 'withdraw',
        'content' => 'Bạn bị từ chối giao dịch rút tiền ['.$withdraw['code'].'], nhận về ['.$withdraw['diamond'].' Kim Cương]',
        'create_time' => time()
      ));
      
      logAdmin('Từ chối giao dịch rút tiền ['.$withdraw['code'].']');
    }
  }
}