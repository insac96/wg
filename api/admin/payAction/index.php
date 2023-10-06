<?php
require 'utils.php';

class Pay extends PayUtils {
  /* Get All Pay Of User */
  public function getAllPay () {
    return getTableList('ny_pay', self::$PDO_GetAllPay);
  }

  /* Search Pay */
  public function searchPay () {
    $sqlCount = "SELECT 
      count(id) AS total 
      FROM ny_pay 
      WHERE code LIKE :query
      OR account LIKE :query
      OR verifier LIKE :query
    ";

    $sqlSearch = "SELECT
      pay.*, gate.name as gate_name
      FROM ny_pay pay
      LEFT JOIN ny_gate gate ON pay.gate_id = gate.id
      WHERE pay.code LIKE :query
      OR pay.account LIKE :query
      OR pay.verifier LIKE :query
    ";

    return getTableSearch($sqlCount, $sqlSearch);
  }

  /* Verify Pay*/
  public function verifyPay ($admin) {
    if(empty($_POST['code']) || !is_numeric($_POST['status']) || !is_numeric($_POST['real_money']))
      return res(400, 'Dữ liệu đầu vào không đủ');

    // Get Pay
    $pay = $this->getPay($_POST['code']);
    if((int)$pay['status'] > 0)
      res(400, 'Không thể thao tác trên giao dịch này');

    // Get Status and Update Pay
    $status = (int)$_POST['status'];
    (new _PDO())->update('ny_pay',
      array(
        'money' => (int)$_POST['real_money'],
        'status' => (int)$status,
        'verify_time' => (int)time(),
        'verifier' => (string)$admin,
      ),
      array('code' => $pay['code'])
    );

    // Is Refuse (Send Notify)
    if($status == 2){
      $reason = !empty($_POST['reason']) ? $_POST['reason'] : 'Sai thông tin giao dịch';
      $notify = 'Bạn bị từ chối giao dịch nạp tiền ['.$pay['code'].'] với lý do ['.$reason.']';
      (new Notify())->create($pay['account'], $notify, 'pay');

      return logAdmin('Từ chối giao dịch nạp tiền ['.$pay['code'].'] với lý do ['.$reason.']');
    }

    // Get User
    $user = (new User())->getUser($pay['account']);
    $vip = (new Vip())->getVip($user['vip']);
    $pay_to_wheel = (int)$vip['pay_to_wheel'];
    $pay_bonus = (int)$vip['pay_bonus'];

    // Get Bonus Of Gate
    $gate = (new Gate())->getGate($pay['gate_id']);
    if(isExpires($gate['expires_bonus']))
      $bonus = (int)$gate['bonus_default'];
    else
      $bonus = (int)$gate['bonus'];
    
    // Get Bonus Of Referraler
    if(!empty($user['referraler'])){
      $referraler = (new User())->getUser($user['referraler']);
      $vip_referraler = (new Vip())->getVip($referraler['vip']);
      $referral_pay_bonus = (int)$vip_referraler['referral_pay_bonus'];
    }
    else {
      $referral_pay_bonus = 0;
    }

    // Set Data Update
    $money = (int)$_POST['real_money'];
    $vip_exp = (int)$money;
    $coin = (int)$money;
    $coin_lock_from_gate = floor($money * $bonus / 100);
    $coin_lock_from_vip = floor($money * $pay_bonus / 100);
    $coin_lock_from_referraler = floor($money * $referral_pay_bonus / 100);
    $coin_lock = (int)$coin_lock_from_gate + (int)$coin_lock_from_vip + (int)$coin_lock_from_referraler;
    $wheel = floor($money / $pay_to_wheel);

    // Update User
    (new User())->updateUser($user['account'], array(
      'vip_exp' => array('+', (int)$vip_exp),
      'coin' => array('+', (int)$coin),
      'wheel' => array('+', (int)$wheel),
      'coin_lock' => array('+', (int)$coin_lock),
      'pay_day' => array('+', (int)$money),
      'pay_month' => array('+', (int)$money),
      'pay_all' => array('+', (int)$money),
    ));

    $notify = 'Bạn được duyệt thành công giao dịch nạp tiền ['.$pay['code'].'], nhận về ['.$coin.' Xu] ['.$coin_lock.' Xu Khóa] ['.$wheel.' Lượt Quay]';
    (new Notify())->create($user['account'], $notify, 'pay');

    logAdmin('Chấp nhận giao dịch nạp tiền ['.$pay['code'].']');

    // Update Referraler
    if($coin_lock_from_referraler == 0 || empty($user['referraler'])) return;
    $diamond = $coin_lock_from_referraler;

    (new User())->updateUser($user['referraler'], array(
      'diamond' => array('+', (int)$diamond),
    ));

    $notify = 'Bạn nhận được ['.$diamond.' Kim Cương] từ giao dịch nạp tiền của ['.$user['account'].']';
    (new Notify())->create($user['referraler'], $notify, 'invitee');
  }
}