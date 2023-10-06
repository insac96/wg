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

  /* Get Pay By Token */
  public function getPayByToken ($token) {
    if(empty($token)) return res(400, 'Dữ liệu đầu vào sai');

    $pay = (new _PDO())->select(self::$PDO_GetPayByToken, array('token' => $token));
    if(empty($pay)) return res(400, 'Giao dịch không tồn tại');
    return $pay;
  }

  /* Get Code By Token */
  public function getPayCodeByToken ($token) {
    if(empty($token)) return res(400, 'Dữ liệu đầu vào sai');

    $pay = (new _PDO())->select(self::$PDO_GetPayCodeByToken, array('token' => $token));
    if(empty($pay)) return res(400, 'Giao dịch không tồn tại');
    return $pay['code'];
  }

  /* Make Code */
  public function makeCode ($pay_id) {
    $config = (new Config())->getConfigAll();
    $prefix = !empty($config['prefix_pay']) ? $config['prefix_pay'] : 'P-';
    return $prefix.''.str_pad($pay_id, 4, '0', STR_PAD_LEFT);
  }

  /* Make Token */
  public function makeToken () {
    $time = strval(time());
    $rand = rand(0, 999);
    return md5($time.$rand);
  }

  /* Get QR Banking */
  public function getQRBanking ($code, $gate) {
    $qr_data = array(
      'amount' => $_POST['money'],
      'addInfo' => $code
    );
    $qr = $gate['qr_link'].'?'.http_build_query($qr_data);
    return $qr;
  }

  /* Get QR Momo */
  public function getQRMomo ($code, $gate) {
    $qr_data = array(
      'phone' => $gate['stk'],
      'amount'=> $_POST['money'],
      'note'=> $code
    );
    $qr = $gate['qr_link'].'?'.http_build_query($qr_data);
    return $qr;
  }

  /* Get Payment Card */
  public function getPaymentCard ($code, $token) {
    $data = $_POST;
    $data['code'] = $code;
    $data['token'] = $token;
    $payment = (new CardPayment())->send($data);

    return $payment;
  }

  /* Auto Verify Pay*/
  public function verifyPayAuto ($realMoney, $code, $status) {
    // Check Pay
    $pay = $this->getPay($code);
    if((int)$pay['status'] > 0) return res(200, 'Refuse');

    // Get Status and Update Pay
    $status = ($realMoney == 0) ? 2 : $status;
    (new _PDO())->update('ny_pay',
      array(
        'money' => (int)$realMoney,
        'status' => (int)$status,
        'verify_time' => (int)time(),
        'verifier' => 'AUTO',
      ),
      array('code' => $pay['code'])
    );

    // Is Refuse (Send Notify)
    if($status == 2){
      $notify = 'Bạn bị từ chối giao dịch nạp tiền ['.$pay['code'].'] với lý do [Sai thông tin]';
      (new Notify())->create($pay['account'], $notify, 'pay');
      return res(200, 'Refuse');
    }

    // Check User and Get VIP
    $user = (new User())->getUser($pay['account']);
    $pay_to_wheel = (int)$user['vip']['pay_to_wheel'];
    $pay_bonus = (int)$user['vip']['pay_bonus'];

    // Get Bonus Of Gate
    $gate = (new Gate())->getGate($pay['gate_id']);
    if(isExpires($gate['expires_bonus']))
      $bonus = (int)$gate['bonus_default'];
    else
      $bonus = (int)$gate['bonus'];

    // Get Bonus Of Referraler
    if(!empty($user['referraler'])){
      $referraler = $user['referraler'];
      $referral_pay_bonus = (int)$referraler['referral_pay_bonus'];
    }
    else {
      $referral_pay_bonus = 0;
    }

    // Set Data Update
    $money = (int)$realMoney;
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
      
    // Update Referraler
    if($coin_lock_from_referraler == 0 || empty($user['referraler'])) return res(200, 'Done');
    $diamond = $coin_lock_from_referraler;

    (new User())->updateUser($user['referraler']['account'], array(
      'diamond' => array('+', (int)$diamond),
    ));

    $notify = 'Bạn nhận được ['.$diamond.' Kim Cương] từ giao dịch nạp tiền của ['.$user['account'].']';
    (new Notify())->create($user['referraler']['account'], $notify, 'invitee');
    return res(200, 'Nạp tiền thành công');
  }
}